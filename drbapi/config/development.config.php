<?php

return [
    // Development time modules
    'modules' => [
        'ZF\Apigility\Admin',
        'ZF\Configuration',
    ],
    // development time configuration globbing
    'module_listener_options' => [
        'config_glob_paths' => ['config/autoload/{,*.}{global,local}-development.php'],
    ],
];