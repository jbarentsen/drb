<?php

namespace DwsApi;

use DwsApi\Rest\RestController;
use Zend\EventManager\Event;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZF\Hal\Entity;
use ZF\Hal\Link\LinkCollection;
use ZF\Hal\Plugin\Hal;

class Module
{

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => [
            ],
            'factories' => [
                'DwsApi\Repository\Endpoint' => 'DwsApi\Repository\Endpoint\EndpointRepositoryFactory',
                'DwsApi\Service\Endpoint' => 'DwsApi\Service\Endpoint\EndpointServiceFactory'
            ]
        );
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
}
