<?php

namespace Gandalflebleu\Rbac\Controller\Factory;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Controller\AdminController;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        $userManager = $container->get(UserManager::class);
        return new AdminController($entityManager, $userManager);
    }

}