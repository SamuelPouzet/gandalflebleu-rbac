<?php

namespace Gandalflebleu\Rbac\Controller\Factory;

use Gandalflebleu\Rbac\Controller\AdminController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new AdminController();
    }

}