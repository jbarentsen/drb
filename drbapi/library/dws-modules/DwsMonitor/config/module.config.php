<?php

namespace DwsMonitor;

return [
    'monitor' => [
        'graylog2' => [
            'enabled' => true,
            'domain' => 'monitoring.development.datawiresport.com',
            'port' => 12201,
            'path' => '/gelf',
            'methods' => [
                'POST',
                'GET',
                'PUT',
                'DELETE',
//                'PATCH',
            ],
        ],
        'filelog' => [
            'enabled' => false,
            'filename' => 'log_' . strtolower(date('F')) . '.txt',
            'directory' => './var/logs/',
        ],
    ],
];
