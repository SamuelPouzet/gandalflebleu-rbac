<?php

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'log' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/log[/:action]',
                    'defaults' => [
                        'controller' => \Gandalflebleu\Rbac\Controller\LogController::class,
                        'action' => 'signin',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            \Gandalflebleu\Rbac\Controller\LogController::class => \Gandalflebleu\Rbac\Controller\Factory\LogControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Gandalflebleu\Rbac\Service\AuthService::class => \Gandalflebleu\Rbac\Service\Factory\AuthServiceFactory::class,
            \Gandalflebleu\Rbac\Service\RouteService::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'gandalflebleu-rbac' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view',
        ],
    ],
];