<?php

namespace Gandalflebleu\Rbac\Manager\Factory;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class UserManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        return new UserManager($entityManager);
    }
}