<?php

namespace NcpFacility\Hydrator\Model\Address;

use Doctrine\Common\Persistence\ObjectManager;
use NcpFacility\Hydrator\Model\AddressHydrator;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

/**
 * Class AddressHydratorFactory
 * @package  NcpFacility\Hydrator\Model\FacilityAddress;
 */
class AddressHydratorFactory
{
    /**
     * @param HydratorPluginManager $hydratorPluginManager
     * @return AddressHydrator
     */
    public function __invoke(HydratorPluginManager $hydratorPluginManager)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $hydratorPluginManager->getServiceLocator();

        /** @var ObjectManager $objectManager */
        $objectManager = $serviceManager->get('doctrine.entitymanager.ormdefault');

        return new AddressHydrator($objectManager);
    }
}
