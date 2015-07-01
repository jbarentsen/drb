<?php

namespace DwsApi\Controller\Console\Endpoint;

use DwsApi\Controller\Console\EndpointController;
use DwsApi\Service\EndpointService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class EndpointControllerFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return EndpointController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $serviceLocator->getServiceLocator();

        /** @var EndpointService $endpointService */
        $endpointService = $serviceManager->get('DwsApi\Service\Endpoint');

        return new EndpointController($endpointService);
    }
}
