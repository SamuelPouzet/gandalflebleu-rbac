<?php

namespace Gandalflebleu\Rbac\Listener;

use Gandalflebleu\Rbac\Providers\ConfigProvider;
use Gandalflebleu\Rbac\Service\AuthService;
use Gandalflebleu\Rbac\Service\RouteService;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Mvc\MvcEvent;


/**
 *
 */
class RbacListener implements  ListenerAggregateInterface
{

    /**
     * @var array
     */
    protected array $listeners = [];
    /**
     * @var EventInterface
     */
    protected EventInterface $event;

    /**
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    /**
     * @param EventManagerInterface $events
     * @param $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'checkAuthorization'], $priority);
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
    public function checkAuthorization(): void
    {
        $routeService = $this->event->getApplication()->getServiceManager()->get(RouteService::class);
        $routeService->init($this->event);
        $authService = $this->event->getApplication()->getServiceManager()->get(AuthService::class);
        $authService->authenticate($routeService);
    }

}