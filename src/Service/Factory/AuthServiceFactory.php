<?php

namespace Gandalflebleu\Rbac\Service\Factory;

use Gandalflebleu\Rbac\Service\AuthenticationService;
use Gandalflebleu\Rbac\Service\AuthService;
use Laminas\Router\RouteMatch;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 *
 */
class AuthServiceFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return AuthService
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('Config');
        if (isset($config['access_filter'])){
            $config = $config['access_filter'];
        }else{
            $config = [
                'mode'=>'restrictive',
                'filters'=>[],
            ];
        }

        $authenticationService = $container->get(AuthenticationService::class);
        return new AuthService($config, $authenticationService);
    }

}