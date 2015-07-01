<?php

return [
    'service_manager' => [
        'factories' => [
            'doctrine.cache.redis_cache' => function ($sm) {
                // FileSystem Cache
                //$cache = new \Doctrine\Common\Cache\FilesystemCache('./var/temp');

                // Array Cache
                $cache = new \Doctrine\Common\Cache\ArrayCache();

                // Redis Cache
//                $cache = new \DoctrineModule\Cache\ZendStorageCache(
//                    $sm->get('Cache\Transient')
//                );

                return $cache;
            },
            'doctrine_sql_logger' => function($sm) {
                $log = new \Zend\Log\Logger();
                $writer = new \Zend\Log\Writer\Stream('./var/sql.log');
                $log->addWriter($writer);

                $sqlLogger = new \Dws\Log\SqlLogger($log);
                return $sqlLogger;
            },
        ]
    ],
    'doctrine' => [
        'sql_logger_collector' => [
            'orm_default' => [
                //'sql_logger' => 'doctrine_sql_logger',
            ],
        ],

        'configuration' => [
            'orm_default' => [
//                'metadata_cache' => 'redis_cache',
//                'query_cache' => 'redis_cache',
//                'result_cache' => 'redis_cache',
//                'hydration_cache' => 'redis_cache',
            ]
        ],
    ],
];

