<?php

namespace Gandalflebleu\Rbac\Listener;

use Gandalflebleu\Rbac\Adapter\Connexion;
use Gandalflebleu\Rbac\Adapter\Result;
use Gandalflebleu\Rbac\Providers\ConfigProvider;
use Gandalflebleu\Rbac\Service\AuthService;
use Gandalflebleu\Rbac\Service\RouteService;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Mvc\Controller\Plugin\Redirect;
use Laminas\Mvc\MvcEvent;


/**
 *
 */
class RbacListener extends AbstractListenerAggregate
{


    /**
     * @param EventInterface $event
     */
    public function __construct()
    {}

    /**
     * @param EventManagerInterface $events
     * @param $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkAuthorization'], $priority);
    }

    /**
     * @param EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events): void
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    /**
     * @return void
     */
    public function checkAuthorization(MvcEvent $event): ?Response
    {
        if($event->getResponse()->getStatusCode() !== 200) {
            return null;
        }
        $routeService = $event->getApplication()->getServiceManager()->get(RouteService::class);
        $routeService->init($event);
        $authService = $event->getApplication()->getServiceManager()->get(AuthService::class);
        $accred = $authService->authenticate($routeService);

        switch($accred->getCode() ) {
            case Connexion::ALLOWED:
                return null;
            case Connexion::NEEDS_CONNEXION:
                return $routeService->redirect($event, 'log', ['action'=>'signin']);
            case Connexion::DENIED:
                return $routeService->redirect($event, 'access-denied');
            default:
                throw new \Exception(sprintf('Result : %1$s response code not implemented', $accred->getCode()));
        }
    }

}