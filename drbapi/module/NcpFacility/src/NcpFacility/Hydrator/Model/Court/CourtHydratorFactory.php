<?php

namespace NcpFacility\Hydrator\Model\Court;

use Doctrine\Common\Persistence\ObjectManager;
use NcpFacility\Hydrator\Model\CourtHydrator;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

/**
 * Class CourtHydratorFactory
 * @package  NcpFacility\Hydrator\Model\Court;
 */
class CourtHydratorFactory
{
    /**
     * @param HydratorPluginManager $hydratorPluginManager
     * @return CourtHydrator
     */
    public function __invoke(HydratorPluginManager $hydratorPluginManager)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $hydratorPluginManager->getServiceLocator();

        /** @var ObjectManager $objectManager */
        $objectManager = $serviceManager->get('doctrine.entitymanager.ormdefault');

        return new CourtHydrator($objectManager);
    }
}
