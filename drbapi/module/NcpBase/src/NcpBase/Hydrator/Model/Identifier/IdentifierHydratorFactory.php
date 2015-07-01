<?php

namespace NcpBase\Hydrator\Model\Identifier;

use Doctrine\Common\Persistence\ObjectManager;
use NcpBase\Hydrator\Model\IdentifierHydrator;
use Zend\Di\ServiceLocator;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

class IdentifierHydratorFactory
{
    /**
     * @param HydratorPluginManager $hydratorPluginManager
     * @return IdentifierHydrator
     */
    public function __invoke(HydratorPluginManager $hydratorPluginManager)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $hydratorPluginManager->getServiceLocator();

        /** @var ObjectManager $objectManager */
        $objectManager = $serviceManager->get('doctrine.entitymanager.ormdefault');

        return new IdentifierHydrator($objectManager);
    }
}
