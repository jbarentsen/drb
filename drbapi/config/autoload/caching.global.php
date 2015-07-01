<?php
return [
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        )
    ),
    'caches' => [
        'Cache\Transient' => [
            'adapter' => 'redis',
            'ttl' => 60,
            'options' => [
                'server' => [
                    'host' => '127.0.0.1',
                    'port' => 6379,
                ]
            ],
            'plugins' => [
                [
                    'name' => 'serializer',
                    'exception_handler' => [
                        'throw_exceptions' => false,
                    ],
                ]
            ],
        ],
        'Cache\Persistence' => [
            'adapter' => 'filesystem',
            'ttl' => 86400,
            'cache_dir' => __DIR__ . '/../../var/cache/',
            'plugins' => [
                'serializer',
            ],
        ],
    ],
];
