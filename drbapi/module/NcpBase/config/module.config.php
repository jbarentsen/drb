<?php

namespace NcpBase;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '',
                    'defaults' => array(
                        'controller' => 'NcpBase\Controller\Admin\IndexController',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => false,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'pagination' => __DIR__ . '/../view/admin/shared/pagination.phtml',
            'layout/layout' => __DIR__ . '/../view/admin/layout/layout.phtml',
            'layout/partials/flashmessages' => __DIR__ . '/../view/admin/layout/partials/flashmessages.phtml',
            'error/index' => __DIR__ . '/../view/admin/error/index.phtml',
            'error/404' => __DIR__ . '/../view/admin/error/404.phtml',
        ),
    ),
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'redis-cache',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Model']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
);
