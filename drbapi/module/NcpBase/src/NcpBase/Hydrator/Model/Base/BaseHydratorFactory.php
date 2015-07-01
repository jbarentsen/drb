<?php

namespace NcpBase\Hydrator\Model\Base;

use Doctrine\Common\Persistence\ObjectManager;
use NcpBase\Hydrator\Model\BaseHydrator;
use Zend\Di\ServiceLocator;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

class BaseHydratorFactory
{
    /**
     * @param HydratorPluginManager $hydratorPluginManager
     * @return BaseHydrator
     */
    public function __invoke(HydratorPluginManager $hydratorPluginManager)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $hydratorPluginManager->getServiceLocator();

        /** @var ObjectManager $objectManager */
        $objectManager = $serviceManager->get('doctrine.entitymanager.ormdefault');

        return new BaseHydrator($objectManager);
    }
}
