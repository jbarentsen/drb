<?php

namespace NcpFacility;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
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
        return [
            'factories' => [
                'NcpFacility\Repository\Court' =>
                    'NcpFacility\Repository\Court\CourtRepositoryFactory',
                'NcpFacility\Repository\Facility' =>
                    'NcpFacility\Repository\Facility\FacilityRepositoryFactory',

                'NcpFacility\Service\Court' =>
                    'NcpFacility\Service\Court\CourtServiceFactory',
                'NcpFacility\Service\Facility' =>
                    'NcpFacility\Service\Facility\FacilityServiceFactory',
            ]
        ];
    }

    /**
     * @return array
     */
    public function getHydratorConfig()
    {
        return [
            'factories' => [
                'NcpFacility\Hydrator\Model\Facility' =>
                    'NcpFacility\Hydrator\Model\Facility\FacilityHydratorFactory',
                'NcpFacility\Hydrator\Model\Court' =>
                    'NcpFacility\Hydrator\Model\Court\CourtHydratorFactory',
            ]
        ];
    }


    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
