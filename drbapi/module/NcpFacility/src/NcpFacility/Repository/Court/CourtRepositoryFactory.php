<?php

namespace NcpFacility\Repository\Court;


use NcpFacility\Repository\CourtRepository;
use Zend\ServiceManager\ServiceLocatorInterface;

class CourtRepositoryFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return CourtRepository
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        return $entityManager->getRepository('NcpFacility\Model\Court');
    }
}
