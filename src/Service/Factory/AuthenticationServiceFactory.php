<?php

namespace Gandalflebleu\Rbac\Service\Factory;

use Gandalflebleu\Rbac\Adapter\AuthAdapter;
use Gandalflebleu\Rbac\Manager\UserManager;
use Gandalflebleu\Rbac\Service\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AuthenticationServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $userManager = $container->get(UserManager::class);
        $authAdapter = $container->get(AuthAdapter::class);

        return new AuthenticationService($userManager, $authAdapter);
    }

}