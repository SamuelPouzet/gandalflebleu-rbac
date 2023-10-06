<?php

namespace Gandalflebleu\Rbac\Service\Factory;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Adapter\AuthAdapter;
use Gandalflebleu\Rbac\Manager\UserManager;
use Gandalflebleu\Rbac\Service\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\Container;
use Psr\Container\ContainerInterface;

class AuthenticationServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AuthenticationService
    {
        $userManager = $container->get(UserManager::class);
        $authAdapter = $container->get(AuthAdapter::class);
        $sessionContainer = $container->get(Container::class);
        $entityManager = $container->get(EntityManager::class);

        return new AuthenticationService($userManager, $authAdapter, $sessionContainer, $entityManager);
    }

}