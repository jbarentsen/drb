<?php

namespace DwsApi\Service\Endpoint;

use DwsApi\Repository\EndpointRepository;
use DwsApi\Service\EndpointService;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointServiceFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return EndpointService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EndpointRepository $endpointRepository */
        $endpointRepository = $serviceLocator->get('DwsApi\Repository\Endpoint');

        /** @var array $moduleConfig */
        $moduleConfig = $serviceLocator->get('Config');

        return new EndpointService($endpointRepository, $moduleConfig);
    }
}
