<?php

namespace Gandalflebleu\Rbac\Controller\Factory;

use Gandalflebleu\Rbac\Controller\LogController;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class LogControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $userManager = $container->get(UserManager::class);
        return new LogController($userManager);
    }
}