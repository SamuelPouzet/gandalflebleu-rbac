<?php
return [
    'factories' => [
        \Gandalflebleu\Rbac\Service\AuthService::class => \Gandalflebleu\Rbac\Service\Factory\AuthServiceFactory::class,
        \Gandalflebleu\Rbac\Service\RouteService::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
    ],
];