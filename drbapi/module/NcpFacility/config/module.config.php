<?php
return [
    'router' => [
        'routes' => [
            'ncp-facility.rest.facility' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/organisation/facility[/:facility_id]',
                    'defaults' => [
                        'controller' => 'NcpFacility\\V1\\Rest\\Facility\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'ncp-facility.rest.facility',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'NcpFacility\\V1\\Rest\\Facility\\FacilityResource' => 'NcpFacility\\V1\\Rest\\Facility\\FacilityResourceFactory',
        ],
    ],
    'zf-rest' => [
        'NcpFacility\\V1\\Rest\\Facility\\Controller' => [
            'listener' => 'NcpFacility\\V1\\Rest\\Facility\\FacilityResource',
            'route_name' => 'ncp-facility.rest.facility',
            'route_identifier_name' => 'facility_id',
            'collection_name' => 'facility',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'NcpFacility\\Model\\Facility',
            'collection_class' => 'NcpFacility\\V1\\Rest\\Facility\\FacilityCollection',
            'service_name' => 'Facility',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'NcpFacility\\V1\\Rest\\Facility\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'NcpFacility\\V1\\Rest\\Facility\\Controller' => [
                0 => 'application/vnd.ncp-facility.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'NcpFacility\\V1\\Rest\\Facility\\Controller' => [
                0 => 'application/vnd.ncp-facility.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            'NcpFacility\\Model\\Facility' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'ncp-facility.rest.facility',
                'route_identifier_name' => 'facility_id',
                'hydrator' => 'NcpFacility\\Hydrator\\Model\\Facility',
            ],
            'NcpFacility\\V1\\Rest\\Facility\\FacilityCollection' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'ncp-facility.rest.facility',
                'route_identifier_name' => 'facility_id',
                'is_collection' => true,
            ],
        ],
    ],
    'doctrine' => [
        'driver' => [
            'NcpFacility_driver' => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
                'cache' => 'redis-cache',
                'paths' => [
                    0 => __DIR__ . '/../src/NcpFacility/Model',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'NcpFacility\\Model' => 'NcpFacility_driver',
                ],
            ],
        ],
    ],
];
