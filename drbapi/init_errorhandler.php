<?php

function customShutdownHandler()
{
    $error = error_get_last();
    if ($error && ($error['type'] & 'E_FATAL')) {
        handler($error['type'], $error['message'], $error['file'], $error['line']);
    }
}

function customErrorHandler($errno, $errstr, $errfile = null, $errline = 0)
{
    switch ($errno) {
        case E_ERROR: // 1 //
            $typestr = 'E_ERROR';
            break;
        case E_WARNING: // 2 //
            $typestr = 'E_WARNING';
            break;
        case E_PARSE: // 4 //
            $typestr = 'E_PARSE';
            break;
        case E_NOTICE: // 8 //
            $typestr = 'E_NOTICE';
            break;
        case E_CORE_ERROR: // 16 //
            $typestr = 'E_CORE_ERROR';
            break;
        case E_CORE_WARNING: // 32 //
            $typestr = 'E_CORE_WARNING';
            break;
        case E_COMPILE_ERROR: // 64 //
            $typestr = 'E_COMPILE_ERROR';
            break;
        case E_CORE_WARNING: // 128 //
            $typestr = 'E_COMPILE_WARNING';
            break;
        case E_USER_ERROR: // 256 //
            $typestr = 'E_USER_ERROR';
            break;
        case E_USER_WARNING: // 512 //
            $typestr = 'E_USER_WARNING';
            break;
        case E_USER_NOTICE: // 1024 //
            $typestr = 'E_USER_NOTICE';
            break;
        case E_STRICT: // 2048 //
            $typestr = 'E_STRICT';
            break;
        case E_RECOVERABLE_ERROR: // 4096 //
            $typestr = 'E_RECOVERABLE_ERROR';
            break;
        case E_DEPRECATED: // 8192 //
            $typestr = 'E_DEPRECATED';
            break;
        case E_USER_DEPRECATED: // 16384 //
            $typestr = 'E_USER_DEPRECATED';
            break;
        default:
            $typestr = 'E_UKNOWN';
            break;
    }
    if ($typestr == 'E_NOTICE') {
        // Do not display notices
        return;
    }
    $message = " Error PHP in file : " . $errfile . " at line : " . $errline . "
    with type error : " . $typestr . " : " . $errstr;
    if (isset($_SERVER['REQUEST_URI'])) {
        $message .= " in " . $_SERVER['REQUEST_URI'];
    }

    if (TRUE) {
        echo $message;
    }
    if (FALSE) {
        //logging...
        try {
            $logger = new Zend\Log\Logger;
            //stream writer
            $writerStream = new Zend\Log\Writer\Stream('var/log/errors_' . date('Ymd') . '-log.txt');
            //mail writer
            $logger->addWriter($writerStream);

            $logger->crit($message);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die;
        }
        //log it!
    }

    /* Don't execute PHP internal error handler */
    return true;
}

register_shutdown_function('customShutdownHandler');
set_error_handler("customErrorHandler");