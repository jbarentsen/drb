<?php

namespace NcpFacility\Service\Court;

use NcpBase\Hydrator\Model\BaseHydrator;
use NcpFacility\Hydrator\Model\CourtHydrator;
use NcpFacility\Repository\CourtRepository;
use NcpFacility\Service\CourtService;
use NcpPermission\Service\Permission\ResourcePermissionService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\HydratorPluginManager;
use NcpFacility\Service\FacilityService;

class CourtServiceFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FacilityService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        /** @var CourtRepository $courtRepository */
        $courtRepository = $serviceLocator->get('NcpFacility\Repository\Court');

        /** @var FacilityService $facilityService */
        $facilityService = $serviceLocator->get('NcpFacility\Service\Facility');

        /** @var  ResourcePermissionService $resourcePermissionService */
        $resourcePermissionService = $serviceLocator->get('NcpPermission\Service\Permission\Resource');

        /** @var HydratorPluginManager $hydratorPluginManager */
        $hydratorPluginManager = $serviceLocator->get('hydratormanager');

        /** @var BaseHydrator $baseHydrator */
        $baseHydrator = $hydratorPluginManager->get('NcpFacility\Hydrator\Court');

        return new CourtService(
            $courtRepository,
            $facilityService,
            $resourcePermissionService,
            $baseHydrator
        );
    }
}
