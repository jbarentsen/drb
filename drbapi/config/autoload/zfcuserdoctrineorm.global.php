<?php

return [
    // telling ZfcUserDoctrineORM to skip the entities it defines
    'zfcuser' => [
        'enable_default_entities' => false,
    ],
    // overriding zfc-user-doctrine-orm's config
    'zfcuser_entity' => [
        'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
        'paths' => [
            'module/NcpUser/src/NcpUser/Model',
        ],
    ],
    'orm_default' => [
        'drivers' => [
            'NcpUser\Model' => 'zfcuser_entity',
        ],
    ],
];
