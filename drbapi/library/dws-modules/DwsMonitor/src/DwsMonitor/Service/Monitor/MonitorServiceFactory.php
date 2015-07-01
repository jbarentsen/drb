<?php

namespace DwsMonitor\Service\Monitor;

use DwsMonitor\Service\MonitorService;
use Zend\ServiceManager\ServiceLocatorInterface;

class MonitorServiceFactory
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return MonitorService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['monitor'];
        $writers = [];
        if ($config['graylog2']['enabled'] === true) {
            $writers[] = $serviceLocator->get('DwsMonitor\Log\GrayLog');
        }
        if ($config['filelog']['enabled'] === true) {
            $writers[] = $serviceLocator->get('DwsMonitor\Log\FileLog');
        }
        return new MonitorService($writers);
    }
}
