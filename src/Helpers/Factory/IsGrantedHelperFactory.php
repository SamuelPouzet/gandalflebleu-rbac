<?php

namespace Gandalflebleu\Rbac\Helpers\Factory;

use Gandalflebleu\Rbac\Helpers\IsGrantedHelper;
use Gandalflebleu\Rbac\Service\RbacService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IsGrantedHelperFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $rbacService = $container->get(RbacService::class);
        return new IsGrantedHelper($rbacService);
    }

}