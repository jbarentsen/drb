<?php

namespace DwsMonitor\Log\GrayLog;

use DwsMonitor\Log\GrayLog;
use Gelf\Publisher;
use Gelf\Transport\HttpTransport;
use Zend\ServiceManager\ServiceLocatorInterface;

class GrayLogPublisherFactory
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Publisher
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['monitor']['graylog2'];

        $transport = new HttpTransport($config['domain'], $config['port'], $config['path']);

        return new Publisher($transport);
    }
}
