<?php

return [
    'controllers' => array(
        'factories' => array(
            'DwsApi\Controller\Console\Endpoint' => 'DwsApi\Controller\Console\Endpoint\EndpointControllerFactory',
        )
    ),
    'console' => [
        'router' => [
            'routes' => [
                'api-endpoints-update' => [
                    'type' => 'simple',
                    'options' => [
                        'route' => 'endpoints update',
                        'defaults' => [
                            'controller' => 'DwsApi\Controller\Console\Endpoint',
                            'action' => 'update'
                        ]
                    ]
                ],
            ],
        ],
    ],
    'doctrine' => [
        'driver' => [
            'DwsApi_driver' => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    0 => __DIR__ . '/../src/DwsApi/Model',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'DwsApi\\Model' => 'DwsApi_driver',
                ],
            ],
        ],
    ],
];
