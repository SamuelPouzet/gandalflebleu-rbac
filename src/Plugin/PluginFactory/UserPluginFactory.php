<?php

namespace Gandalflebleu\Rbac\Plugin\PluginFactory;

use Gandalflebleu\Rbac\Plugin\UserPlugin;
use Gandalflebleu\Rbac\Service\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class UserPluginFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $authenticationService = $container->get(AuthenticationService::class);
        return new UserPlugin($authenticationService);
    }

}