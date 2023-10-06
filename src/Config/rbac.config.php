<?php

namespace Gandalflebleu\Rbac;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Adapter\AuthAdapter;
use Gandalflebleu\Rbac\Adapter\Connexion;
use Gandalflebleu\Rbac\Adapter\Factory\AuthAdapterFactory;
use Gandalflebleu\Rbac\Adapter\Result;
use Gandalflebleu\Rbac\Controller\Factory\LogControllerFactory;
use Gandalflebleu\Rbac\Controller\LogController;
use Gandalflebleu\Rbac\Manager\Factory\UserManagerFactory;
use Gandalflebleu\Rbac\Manager\UserManager;
use Gandalflebleu\Rbac\Plugin\PluginFactory\UserPluginFactory;
use Gandalflebleu\Rbac\Plugin\UserPlugin;
use Gandalflebleu\Rbac\Service\AuthenticationService;
use Gandalflebleu\Rbac\Service\AuthService;
use Gandalflebleu\Rbac\Service\Factory\AuthenticationServiceFactory;
use Gandalflebleu\Rbac\Service\Factory\AuthServiceFactory;
use Gandalflebleu\Rbac\Service\Factory\RbacServiceFactory;
use Gandalflebleu\Rbac\Service\Factory\RoleServiceFactory;
use Gandalflebleu\Rbac\Service\RbacService;
use Gandalflebleu\Rbac\Service\RoleService;
use Gandalflebleu\Rbac\Service\RouteService;
use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Session;

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
            LogController::class => LogControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            AuthService::class => AuthServiceFactory::class,
            RouteService::class => InvokableFactory::class,
            AuthenticationService::class => AuthenticationServiceFactory::class,

            UserManager::class => UserManagerFactory::class,

            AuthAdapter::class => AuthAdapterFactory::class,
            Result::class => InvokableFactory::class,
            Connexion::class => InvokableFactory::class,
            RbacService::class => RbacServiceFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            UserPlugin::class => UserPluginFactory::class,
        ],
        'aliases' => [
            'currentUser' => UserPlugin::class,
        ]
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
                'paths' => [dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'session_containers' => [
        Session\Container::class,
    ],
    'session_storage' => [
        'type' => Session\Storage\SessionArrayStorage::class,
    ],
    'session_config' => [
        'gc_maxlifetime' => 7200,
        // …
    ],
    'access_filter' => [
        'filters' => [
            \Gandalflebleu\Rbac\Controller\LogController::class => [
                'index' => [
                    '@',
                ],
            ],
        ],
    ],
    'caches' => [
        'fileSystemCache' => [
            'adapter' => Filesystem::class,
            'options' => [
                'cache_dir' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'cache',
                // Store cached data for 1 hour.
                'ttl' => 60 * 60 * 1,
            ],
        ],
    ],
];