<?php
namespace NcpFacility\V1\Rest\Facility;

use NcpFacility\Service\FacilityService;
use Zend\ServiceManager\ServiceLocatorInterface;

class FacilityResourceFactory
{
        /**
         * @param ServiceLocatorInterface $serviceLocator
         * @return FacilityResource
         */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        /** @var FacilityService $facilityService */
        $facilityService = $serviceLocator->get('NcpFacility\Service\Facility');


        return new FacilityResource(
            $facilityService
        );
    }
}
