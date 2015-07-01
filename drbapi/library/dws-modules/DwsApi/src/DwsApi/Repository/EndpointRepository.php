<?php

namespace DwsApi\Repository;

use DwsBase\Repository\AbstractRepository;
use DwsApi\Model\Endpoint;

class EndpointRepository extends AbstractRepository
{
    /**
     * @var string Model name
     */
    protected $modelClassName = 'DwsApi\Model\Endpoint';

    /**
     * @param Endpoint $endpoint
     */
    public function persist(Endpoint $endpoint)
    {
        $this->getEntityManager()->persist($endpoint);
    }

    /**
     * @param Endpoint $endpoint
     */
    public function remove(Endpoint $endpoint)
    {
        $this->getEntityManager()->remove($endpoint);
    }

    /**
     * @param string $route
     * @param string $requestMethod
     * @return Endpoint|null
     */
    public function findOneByRouteAndRequestMethod($route, $requestMethod)
    {
        return $this->findOneBy([
            'route' => $route,
            'requestMethod' => $requestMethod
        ]);
    }
}
