<?php

namespace Gandalflebleu\Rbac\Controller\Factory;

use Gandalflebleu\Rbac\Controller\LogController;
use Gandalflebleu\Rbac\Service\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class LogControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $authService = $container->get(AuthenticationService::class);
        return new LogController($authService);
    }
}