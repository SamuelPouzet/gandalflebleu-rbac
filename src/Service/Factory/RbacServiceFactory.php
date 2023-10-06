<?php

namespace Gandalflebleu\Rbac\Service\Factory;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Service\RbacService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RbacServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        $cache = $container->get('fileSystemCache');
        return new RbacService($entityManager, $cache);
    }

}