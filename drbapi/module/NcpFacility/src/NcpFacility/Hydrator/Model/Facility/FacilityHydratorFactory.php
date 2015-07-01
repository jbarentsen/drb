<?php

namespace NcpFacility\Hydrator\Model\Facility;

use Doctrine\Common\Persistence\ObjectManager;
use NcpBase\Hydrator\Model\BaseHydrator;
use NcpFacility\Hydrator\Model\FacilityHydrator;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

/**
 * Class FacilityHydratorFactory
 * @package  NcpFacility\Hydrator\Model\Facility;
 */
class FacilityHydratorFactory
{
    /**
     * @param HydratorPluginManager $hydratorPluginManager
     * @return FacilityHydrator
     */
    public function __invoke(HydratorPluginManager $hydratorPluginManager)
    {
        /** @var BaseHydrator $baseHydrator */
        $baseHydrator = $hydratorPluginManager->get('NcpBase\Hydrator\Model\Base');

        /** @var ServiceManager $serviceManager */
        $serviceManager = $hydratorPluginManager->getServiceLocator();

        /** @var ObjectManager $objectManager */
        $objectManager = $serviceManager->get('doctrine.entitymanager.ormdefault');

        return new FacilityHydrator(
            $baseHydrator,
            $objectManager
        );
    }
}
