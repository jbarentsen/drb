<?php

namespace NcpFacility\Repository\Facility;


use NcpFacility\Repository\FacilityRepository;
use Zend\ServiceManager\ServiceLocatorInterface;

class FacilityRepositoryFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FacilityRepository
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        return $entityManager->getRepository('NcpFacility\Model\Facility');
    }
}
