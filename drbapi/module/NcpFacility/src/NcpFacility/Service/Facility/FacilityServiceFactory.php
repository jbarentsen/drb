<?php

namespace NcpFacility\Service\Facility;

use NcpFacility\Hydrator\Model\FacilityHydrator;
use NcpFacility\Repository\FacilityRepository;
use NcpOrganisation\Service\OrganisationService;
use NcpPermission\Service\Permission\ResourcePermissionService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\HydratorPluginManager;
use NcpFacility\Service\FacilityService;

class FacilityServiceFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FacilityService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        /** @var FacilityRepository $facilityRepository */
        $facilityRepository = $serviceLocator->get('NcpFacility\Repository\Facility');

        /** @var OrganisationService $organisationService */
        $organisationService = $serviceLocator->get('NcpOrganisation\Service\Organisation');

        /** @var  ResourcePermissionService $resourcePermissionService */
        $resourcePermissionService = $serviceLocator->get('NcpPermission\Service\Permission\Resource');

        /** @var HydratorPluginManager $hydratorPluginManager */
        $hydratorPluginManager = $serviceLocator->get('hydratormanager');

        /** @var FacilityHydrator $facilityHydrator */
        $facilityHydrator = $hydratorPluginManager->get('NcpFacility\Hydrator\Model\Facility');

        return new FacilityService(
            $facilityRepository,
            $resourcePermissionService,
            $facilityHydrator,
            $organisationService
        );
    }
}
