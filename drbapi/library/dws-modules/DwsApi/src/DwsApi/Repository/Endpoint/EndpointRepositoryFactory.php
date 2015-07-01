<?php

namespace DwsApi\Repository\Endpoint;

use DwsApi\Repository\EndpointRepository;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointRepositoryFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return EndpointRepository
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        return $entityManager->getRepository('DwsApi\Model\Endpoint');
    }
}
