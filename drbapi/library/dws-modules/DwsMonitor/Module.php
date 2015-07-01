<?php

namespace DwsMonitor;

use Zend\Console\Console;
use Zend\Mvc\MvcEvent;

class Module
{
    
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        $serviceManager = $application->getServiceManager();
        if (!Console::isConsole()) {
            $eventManager->attach(
                MvcEvent::EVENT_DISPATCH,
                $serviceManager->get('DwsMonitor\Listener\ApiLogListener'),
                90
            );
        }
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'invokables' => [
            ],
            'factories' => [
                'DwsMonitor\Service\MonitorService' => 'DwsMonitor\Service\Monitor\MonitorServiceFactory',
                'DwsMonitor\Listener\ApiLogListener' => 'DwsMonitor\Listener\ApiLogListener\ApiLogListenerFactory',
                'DwsMonitor\Log\GrayLog' => 'DwsMonitor\Log\GrayLog\GrayLogFactory',
                'DwsMonitor\Log\GrayLog\GrayLogPublisher' => 'DwsMonitor\Log\GrayLog\GrayLogPublisherFactory',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
