<?php

namespace DwsMonitor\Log\File;

use DwsMonitor\Log\FileLog;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as LogWriterStream;

class FileLogFactory
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FileLog
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['monitor']['filelog'];
        if (is_writable($config['directory'] . $config['filename'])) {
            $log = new Logger();
            $writer = new LogWriterStream($config['directory'] . $config['filename']);
            $log->addWriter($writer);
        } else {
            $log = null;
        }
        return new FileLog($log);
    }
}
