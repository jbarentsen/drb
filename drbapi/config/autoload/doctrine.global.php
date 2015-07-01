<?php

$dbParams = [
    'port' => 3306,
    'driver' => 'PdoMysql',
    'hostname' => 'localhost',
    'database' => 'ta_ncp',
    'username' => 'dws',
    'password' => 'dws',
];

return [
    'db' => [
        'driver' => $dbParams['driver'],
        'hostname' => $dbParams['hostname'],
        'database' => $dbParams['database'],
        'username' => $dbParams['username'],
        'password' => $dbParams['password'],
    ],
    'doctrine' => [
        'orm' => [
            'entity_managers' => [
                'default' => [
                    'mappings' => [
                        'NcpBase' => [
                            'type' => 'annotation',
                        ],
                        'custom_mapping' => [
                            'type' => 'annotation',
                            'prefix' => 'Client\\IntranetBundle\\LDAP\\',
                            'dir' => '%kernel.root_dir%/vagrant/library/dws-modules/DwsBase/src/Model/',
                            'is_bundle' => false,
                        ],
                    ],
                ],
            ],
        ],
        'connection' => [
            'orm_default' => [
                'params' => [
                    'host' => $dbParams['hostname'],
                    'port' => $dbParams['port'],
                    'user' => $dbParams['username'],
                    'password' => $dbParams['password'],
                    'dbname' => $dbParams['database'],
                    'driverOptions' => [
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    ],
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'namingStrategy' => new Dws\Doctrine\ORM\Mapping\DwsNamingStrategy(),
                //'metadata_cache' => 'filesystem',
                //'query_cache' => 'filesystem',
                //'result_cache' => 'filesystem',
                //'hydration_cache' => 'filesystem',
                'types' => [
                    'datetime' => 'Dws\UTCDateTimeType',
                ],
            ],
        ],
        //'config_cache_enabled' => true,
        'cache' => [
            'filesystem' => [
                'class' => 'Doctrine\Common\Cache\FilesystemCache',
                'directory' => __DIR__ . '/../../var/cache/',
                'namespace' => 'DoctrineModule',
            ],
        ],
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    'Gedmo\Timestampable\TimestampableListener',
                ],
            ],
        ],
        // migrations configuration
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/migrations',
                'name' => 'Doctrine Database Migrations',
                'namespace' => 'DoctrineORMModule\Migrations',
                'table' => 'migrations',
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'doctrine.cache.redis_cache' => function ($sm) {
                // Use array cache for now, in order to keep settings in place
                $cache = new \Doctrine\Common\Cache\ArrayCache();
                return $cache;
            }
        ]
    ]
];
