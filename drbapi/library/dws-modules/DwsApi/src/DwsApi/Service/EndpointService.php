<?php

namespace DwsApi\Service;

use Dws\Exception\ServiceException;
use DwsApi\Model\Endpoint;
use DwsApi\Repository\EndpointRepository;
use NcpPermission\Model\Rule;

class EndpointService
{
    /**
     * @var EndpointRepository
     */
    private $endpointRepository;

    /**
     * @var array
     */
    private $moduleConfig;

    /**
     * Constructor
     *
     * @param EndpointRepository $endpointRepository
     * @param array $moduleConfig
     */
    public function __construct(EndpointRepository $endpointRepository, array &$moduleConfig)
    {
        $this->endpointRepository = $endpointRepository;
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * Add new endpoints and remove old references. This should be a step in the deployment
     * process because routes can be changed.
     *
     * @throws ServiceException
     */
    public function update()
    {
        if (!is_array($this->moduleConfig['zf-rest']) ||
            !is_array($this->moduleConfig['router']) ||
            !is_array($this->moduleConfig['router']['routes'])) {
            throw new ServiceException('Invalid route path(s)');
        }

        /** @var Endpoint[] $currentEndpoints */
        $currentEndpoints = [];
        foreach ($this->moduleConfig['zf-rest'] as $controllerName => &$resourceRouteConfig) {
            if (!isset($resourceRouteConfig['route_name']) || // skip undefined routes
                substr($controllerName, 0, strpos($controllerName, '\\', 1)) === 'ZF') { // skip Apigility routes
                continue;
            }
            $this->getCurrentEndpoints($resourceRouteConfig, $currentEndpoints);
        }

        /** @var Endpoint[] $existingEndpoints */
        $existingEndpoints = $this->endpointRepository->findAll();

        // unset existing endpoints
        foreach ($existingEndpoints as $existingEndpointKey => &$existingEndpoint) {
            foreach ($currentEndpoints as $currentEndpointKey => &$currentEndpoint) {
                if ($currentEndpoint->getRoute() === $existingEndpoint->getRoute() &&
                    $currentEndpoint->getRequestMethod() === $existingEndpoint->getRequestMethod()
                ) {
                    unset($existingEndpoints[$existingEndpointKey]);
                    unset($currentEndpoints[$currentEndpointKey]);
                    break;
                }
            }
        }

        // create new endpoints
        foreach ($currentEndpoints as &$currentEndpoint) {
//            echo sprintf( // TODO: add logging
//                'Adding new endpoint %s %s%s',
//                $currentEndpoint->getRequestMethod(),
//                $currentEndpoint->getRoute(),
//                PHP_EOL
//            );
            $this->endpointRepository->persist($currentEndpoint);
        }

        // remove old endpoints
        foreach ($existingEndpoints as &$existingEndpoint) {
//            echo sprintf( // TODO: add logging
//                'Adding new endpoint %s %s',
//                $existingEndpoint->getRequestMethod(),
//                $existingEndpoint->getRoute(),
//                PHP_EOL
//            );
            $this->endpointRepository->remove($existingEndpoint);
        }

        $this->endpointRepository->flush();
    }

    /**
     * Get endpoints for both a single resource and resource collections from resource
     * routes and their allowed HTTP methods.
     *
     * @param array $resourceRouteConfig
     * @param array $endpoints
     * @throws ServiceException
     */
    private function getCurrentEndpoints(array &$resourceRouteConfig, array &$endpoints)
    {
        $routeConfig = $this->moduleConfig['router']['routes'][$resourceRouteConfig['route_name']];
        if (!is_array($routeConfig['options'])) {
            throw new ServiceException(sprintf(
                'Invalid route path(s) defined for route \'%s\'',
                $resourceRouteConfig['route_name']
            ));
        }

        $entityRoute = $routeConfig['options']['route'];
        $entityMethods = $resourceRouteConfig['entity_http_methods'];
        $collectionMethods = $resourceRouteConfig['collection_http_methods'];
        $routeIdentifierLabel = sprintf(':%s', $resourceRouteConfig['route_identifier_name']);

        // add resource collection endpoints
        foreach ($collectionMethods as $collectionRequestMethod) {
            $collectionRoute = preg_replace('/\[?([a-z0-9\/]+)' . $routeIdentifierLabel . '\]?/i', '', $entityRoute);
            $this->addEndpoint($collectionRoute, $collectionRequestMethod, $endpoints);
        }

        // add single resource endpoints
        foreach ($entityMethods as $entityRequestMethod) {
            $this->addEndpoint($entityRoute, $entityRequestMethod, $endpoints);
        }
    }

    /**
     * @param string $route
     * @param string $method
     * @param Endpoint[] $endpoints
     */
    private function addEndpoint($route, $method, array &$endpoints)
    {
        /** @var Endpoint $endpoint */
        foreach ($endpoints as $endpoint) {
            if ($method === $endpoint->getRequestMethod() &&
                $route === $endpoint->getRoute()) {
                return;
            }
        }
        $endpoints[] = new Endpoint($route, $method);
    }
}
