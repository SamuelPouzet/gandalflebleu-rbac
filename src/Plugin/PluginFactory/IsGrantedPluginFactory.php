<?php

namespace Gandalflebleu\Rbac\Plugin\PluginFactory;

use Gandalflebleu\Rbac\Plugin\IsGrantedPlugin;
use Gandalflebleu\Rbac\Service\RbacService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IsGrantedPluginFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $rbacService = $container->get(RbacService::class);
        return new IsGrantedPlugin($rbacService);
    }

}