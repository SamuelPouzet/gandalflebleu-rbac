<?php

namespace Gandalflebleu\Rbac\Service;

use Laminas\EventManager\EventInterface;
use Laminas\Router\RouteMatch;

class AuthService
{

    protected string $mode;

    protected array $permissions;

    protected array $filters;

    const MODE_RESTRICTIVE = 'restrictive';
    const MODE_PERMISSIVE = 'permissive';
    public function __construct(array $config)
    {
        $this->setMode($config['mode']);
        $this->setFilters($config['filters']);
    }

    protected function setMode(string $mode): void
    {
        if(!in_array($mode, [static::MODE_PERMISSIVE, static::MODE_RESTRICTIVE])){
            throw new \Exception('Rbac mode should be %1$s or %2$s', static::MODE_RESTRICTIVE, static::MODE_PERMISSIVE);
        }

        $this->mode = $mode;
    }

    protected function setFilters(array $filters)
    {
        $this->filters = $filters;
    }

    public function authenticate(RouteService $routeService): bool
    {
        if(! isset($this->filters[$routeService->getControllerName()])) {
            if($this->mode === static::MODE_PERMISSIVE) {
                return true;
            }
            return false;
        }
        $controllerFilter = $this->filters[$routeService->getControllerName()];
        if(! isset($controllerFilter[$routeService->getActionName()])) {
            if($this->mode === static::MODE_PERMISSIVE) {
                return true;
            }
            return false;
        }
        $actionFilter = $controllerFilter[$routeService->getActionName()];
        if(in_array('*', $actionFilter)) {
            return true;
        }
        return true;
    }
}