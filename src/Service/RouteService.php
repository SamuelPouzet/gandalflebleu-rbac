<?php

namespace Gandalflebleu\Rbac\Service;

use Gandalflebleu\Rbac\Controller\LogController;
use Laminas\EventManager\EventInterface;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Controller\Plugin\Redirect;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;

/**
 * class RouteService
 */
class RouteService
{

    /**
     * @var string
     */
    protected string $controllerName;
    /**
     * @var string
     */
    protected string $actionName;
    /**
     * @var RouteMatch
     */
    protected RouteMatch $routeMatch;


    /**
     * @param EventInterface $event
     * @return void
     */
    public function init(EventInterface $event): void
    {
        $this->routeMatch = $event->getRouteMatch();
        $this->setControllerName();
        $this->setActionName();
    }

    /**
     * @return void
     */
    protected function setControllerName(): void
    {
        $this->controllerName =  $this->routeMatch->getParam('controller', null);
    }

    /**
     * @return void
     */
    protected function setActionName(): void
    {
        $actionName = $this->routeMatch->getParam('action', null);
        $this->actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @return RouteMatch
     */
    public function getRouteMatch(): RouteMatch
    {
        return $this->routeMatch;
    }

    public function redirect(MvcEvent $event, string $routename, array $params=[]): Response
    {
        return $event->getTarget()->redirect()->toRoute($routename, $params);
    }


}