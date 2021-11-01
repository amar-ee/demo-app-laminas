<?php

declare(strict_types=1);

namespace Album;

use Album\Hydrator\AlbumHydrator;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Segment;
use Album\Controller\AlbumController;
use Album\Service\AlbumService;
use Album\Service\AlbumServiceFactory;

return [
    'router' => [
        'routes' => [
            'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'application-driver' => [
                'class' => AnnotationDriver::class,
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Album\Entity' => 'application-driver',
                ],
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            AlbumHydrator::class => AlbumHydrator::class,
        ],
        'factories' => [
            AlbumService::class => AlbumServiceFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AlbumController::class => Controller\AlbumControllerFactory::class
        ],
    ],
];

