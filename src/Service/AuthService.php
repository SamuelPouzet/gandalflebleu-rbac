<?php

namespace Gandalflebleu\Rbac\Service;

use Gandalflebleu\Rbac\Adapter\Connexion;
use Gandalflebleu\Rbac\Controller\LogController;
use Laminas\EventManager\EventInterface;
use Laminas\Router\RouteMatch;

class AuthService
{

    protected string $mode;

    protected array $permissions;

    protected array $filters;

    protected AuthenticationService $authenticationService;

    protected Connexion $connexion;

    const MODE_RESTRICTIVE = 'restrictive';
    const MODE_PERMISSIVE = 'permissive';

    public function __construct(array $config, AuthenticationService $authenticationService, Connexion $connexion)
    {
        $this->setMode($config['mode'] ?? static::MODE_RESTRICTIVE);
        $this->setFilters($config['filters']);

        $this->authenticationService = $authenticationService;
        $this->connexion = $connexion;
    }

    protected function setMode(string $mode): void
    {
        if (!in_array($mode, [static::MODE_PERMISSIVE, static::MODE_RESTRICTIVE])) {
            throw new \Exception('Rbac mode should be %1$s or %2$s', static::MODE_RESTRICTIVE, static::MODE_PERMISSIVE);
        }

        $this->mode = $mode;
    }

    protected function setFilters(array $filters)
    {
        $this->filters = $filters;
    }

    public function authenticate(RouteService $routeService): Connexion
    {
        $controllerName = $routeService->getControllerName();

        if($controllerName === LogController::class) {
            return $this->setConnexion(Connexion::ALLOWED);
        }

        if (!isset($this->filters[$controllerName])) {
            if ($this->mode === static::MODE_PERMISSIVE) {
                return $this->setConnexion(Connexion::ALLOWED);
            }
            return $this->setConnexion(Connexion::DENIED, sprintf('filter not found for controller %1$s', $controllerName ));
        }

        $controllerFilter = $this->filters[$controllerName];
        if (!isset($controllerFilter[$routeService->getActionName()])) {
            if ($this->mode === static::MODE_PERMISSIVE) {
                return $this->setConnexion(Connexion::ALLOWED);
            }
            return $this->setConnexion(Connexion::DENIED,
                sprintf('filter not found for action %1$s controller %2$s',
                    $routeService->getActionName(),
                    $controllerName
                ));
        }
        $actionFilter = $controllerFilter[$routeService->getActionName()];
        if (in_array('*', $actionFilter)) {
            return $this->setConnexion(Connexion::ALLOWED);
        }

        //user must be connected
        if (! $this->authenticationService->isAuthenticated()) {
            return $this->setConnexion(Connexion::NEEDS_CONNEXION);
        }

        //page allowed to all connected users
        if (in_array('@', $actionFilter)) {
            return $this->setConnexion(Connexion::ALLOWED);
        }

        //we'll need user's account
        $userAccount = $this->authenticationService->getAuthentication();

        //page allowed to specific role
        //@todo

        //page allowed to specific permission
        //@todo

        //page allowed to specific users
        if(isset($actionFilter['allowed_users'])) {
            if(in_array($userAccount->getLogin(), $actionFilter['allowed_users'] )) {
                 return $this->setConnexion(Connexion::ALLOWED);
            }
        }

        return $this->setConnexion(Connexion::DENIED);
    }

    protected function setConnexion($code, $message='')
    {
        $this->connexion->setCode($code);
        $this->connexion->setMessage($message);
        return $this->connexion;
    }
}