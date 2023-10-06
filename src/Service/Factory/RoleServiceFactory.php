<?php

namespace Gandalflebleu\Rbac\Service\Factory;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Service\RoleService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RoleServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): RoleService
    {
        $cache = $container->get('fileSystemCache');
        $entityManager = $container->get(EntityManager::class);
        return new RoleService($cache, $entityManager);
    }

}