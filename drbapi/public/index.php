<?php

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}
defined('APP_ENV') || define('APP_ENV', (getenv('APP_ENV') ?: 'production'));
defined('APP_PATH') || define('APP_PATH', realpath(__DIR__ . '/../'));

// Setup autoloading
require 'init_autoloader.php';

// We would need here graylog2 integration, for production mode, if an exception
// does not get caught by ZF2 error handling. For now unneeded, as we test on PHP-FPM
//require 'init_errorhandler.php';


$appConfig = include APP_PATH . '/config/application.config.php';

if (APP_ENV == 'development' && file_exists(APP_PATH . '/config/development.config.php')) {
    $appConfig = Zend\Stdlib\ArrayUtils::merge($appConfig, include APP_PATH . '/config/development.config.php');
}

// Run the application!
try {
    Zend\Mvc\Application::init($appConfig)->run();
} catch (\Exception $e) {
    var_dump($e->getMessage());

    //customErrorHandler(0, $e->getMessage());
}
