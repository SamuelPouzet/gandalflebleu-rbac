<?php

namespace Gandalflebleu\Rbac\Providers;

use Gandalflebleu\Rbac\Service\RouteService;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ServiceManager\ServiceManager;

/**
 *
 */
class ConfigProvider
{
    /**
     * @param ServiceManager $serviceManager
     * @return void
     */
    public static function provide(ServiceManager $serviceManager): void
    {

        $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'rbac.config.php';
        $serviceManager->configure(include $file);
    }
}