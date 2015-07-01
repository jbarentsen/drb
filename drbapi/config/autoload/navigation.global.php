<?php

return [
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format' => '<div %s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
            'message_close_string' => '</div>',
            'message_separator_string' => '<br/>',
        ],
    ],
    'navigation' => [
        'default' => [
            /*
            array(
                'label' => 'Home',
                'route' => 'manager.home',
            ),
            array(
                'label' => 'Landing users',
                'route' => 'admin.user',
                'params' => array(
                    'id' => '1',
                ),
                'pages' => array(
                    array(
                        'label' => 'Browse users',
                        'route' => 'admin.user/browse',
                        'params' => array(
                            'id' => '1',
                        ),
                    ),
                    array(
                        'label' => 'Add user',
                        'route' => 'admin.user/add',
                    ),
                    array(
                        'label' => 'Search user',
                        'route' => 'admin.user/search',
                    ),
                ),
            ),
            array(
                'label' => 'Landing organisations',
                'route' => 'admin.organisation',
                'pages' => array(
                    array(
                        'label' => 'Browse organisation',
                        'route' => 'admin.organisation/browse',
                    ),
                    array(
                        'label' => 'Add organisation',
                        'route' => 'admin.organisation/add',
                    ),
                    array(
                        'label' => 'Search organisation',
                        'route' => 'admin.organisation/search',
                    ),
                ),
            ),
            array(
                'label' => 'Landing persons',
                'route' => 'admin.person',
                'pages' => array(
                    array(
                        'label' => 'Browse persons',
                        'route' => 'admin.person/browse',
                    ),
                    array(
                        'label' => 'Add person',
                        'route' => 'admin.person/add',
                    ),
                    array(
                        'label' => 'Search person',
                        'route' => 'admin.person/search',
                    ),
                ),
            ),
            array(
                'label' => 'Processes persons',
                'route' => 'admin.person/search',
                'pages' => array(
                    array(
                        'label' => 'Create new league',
                        'route' => 'admin.league.create/entry',
                        'params' => array(
                            'id' => '33002',
                        ),
                    ),
                ),
            ),
             */
        ],
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => 'NcpBase\Service\Admin\Navigation\NavigationServiceFactory',
        ],
    ],
];
