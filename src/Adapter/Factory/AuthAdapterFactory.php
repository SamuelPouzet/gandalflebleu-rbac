<?php

namespace Gandalflebleu\Rbac\Adapter\Factory;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Adapter\AuthAdapter;
use Gandalflebleu\Rbac\Adapter\Result;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AuthAdapterFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $result = $container->get(Result::class);
        $entityManager = $container->get(EntityManager::class);
        return new AuthAdapter($result, $entityManager);
    }
    
}