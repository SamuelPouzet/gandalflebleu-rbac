<?php

namespace Gandalflebleu\Rbac\Listener;

use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;

class RbacListener
{

    protected MvcEvent $event;
    protected array $listeners = [];

    public function __construct(MvcEvent $event)
    {
        $this->event = $event;
    }

    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH,
            $this->checkAuthorization()
        );
    }

    protected function checkAuthorization()
    {
        die('checking auth');
    }
}