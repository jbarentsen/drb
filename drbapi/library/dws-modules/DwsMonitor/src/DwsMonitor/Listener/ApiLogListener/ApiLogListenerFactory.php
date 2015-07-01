<?php

namespace DwsMonitor\Listener\ApiLogListener;

use DwsMonitor\Listener\ApiLogListener;
use DwsMonitor\Service\MonitorService;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApiLogListenerFactory
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ApiLogListener
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['monitor']['graylog2'];

        /* @var $monitor MonitorService */
        $monitor = $serviceLocator->get('DwsMonitor\Service\MonitorService');

        return new ApiLogListener($config, $monitor);
    }
}