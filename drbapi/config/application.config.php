<?php

use Zend\Console\Console;

$modules = [
    'ZfSimpleMigrations',

    'DoctrineModule',
    'DoctrineORMModule',

    'SlmQueue',
    'SlmQueueBeanstalkd',

    'ZfcBase',
    'ZfcUser',
    'ZfcUserDoctrineORM',
    'ZF\Apigility',
    'ZF\Apigility\Provider',
    'AssetManager',
    'ZF\ApiProblem',
    'ZF\MvcAuth',
    'ZF\OAuth2',
    'ZF\OAuth2\Doctrine',
    'ZF\Hal',
    'ZF\ContentNegotiation',
    'ZF\ContentValidation',
    'ZF\Rest',
//        'ZF\Rpc',
    'ZF\Versioning',

    'DwsApi',
    'DwsAuth',
    'DwsBase',
    'DwsMonitor',

    'NcpBase',
    'NcpCommunication',
    'NcpDivision',
    'NcpFacility',
    'NcpLadder',
    'NcpLeague',
    'NcpMatch',
    'NcpNotification',
    'NcpOrganisation',
    'NcpPermission',
    'NcpPerson',
    'NcpTeam',
    'NcpUser',
];


if (APP_ENV == 'development') {
    $modules[] = 'ZendDeveloperTools';
    $modules[] = 'ZF\DevelopmentMode';
}

$config = [
    // This should be an array of module namespaces used in the application.
    'modules' => $modules,
    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => [
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths' => [
            './module',
            './library/dws-modules',
            './vendor',
        ],
        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => [
            sprintf('config/autoload/{,*.}{global,%s,local}.php', APP_ENV),
        ],
    ],
];

if (Console::isConsole()) {
    if (strpos($_SERVER['SCRIPT_NAME'], 'vendor/bin') !== 0) {
        //array_splice($config['modules'], array_search('DwsNotification', $config['modules']), 1);
    }
}
return $config;
