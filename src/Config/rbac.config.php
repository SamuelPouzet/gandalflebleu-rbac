<?php

namespace Gandalflebleu\Rbac;

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

            \Gandalflebleu\Rbac\Manager\UserManager::class=>\Gandalflebleu\Rbac\Manager\Factory\UserManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'gandalflebleu-rbac' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [ dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];