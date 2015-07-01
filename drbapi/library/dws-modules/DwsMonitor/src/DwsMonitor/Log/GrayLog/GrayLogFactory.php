<?php

namespace DwsMonitor\Log\GrayLog;

use DwsMonitor\Log\GrayLog;
use Gelf\Publisher;
use Zend\ServiceManager\ServiceLocatorInterface;

class GrayLogFactory
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return GrayLog
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $publisher Publisher */
        $publisher = $serviceLocator->get('DwsMonitor\Log\GrayLog\GrayLogPublisher');

        return new GrayLog($publisher);
    }
}
