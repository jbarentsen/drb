<?php

namespace DwsApi\Model;

use Doctrine\ORM\Mapping as ORM;
use Dws\Exception\ModelException;
use Dws\Model\Traits\TimestampableTrait;

/**
 * Describes an API endpoint
 *
 * @ORM\Entity(repositoryClass="DwsApi\Repository\EndpointRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique", columns={"route", "requestMethod"})
 * })
 */
class Endpoint
{
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT = 'PUT';
    const REQUEST_METHOD_PATCH = 'PATCH';
    const REQUEST_METHOD_DELETE = 'DELETE';

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", precision=0, scale=0, nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, precision=0, scale=0, nullable=false)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=6, precision=0, scale=0, nullable=false)
     */
    private $requestMethod;

    /**
     * Constructor
     *
     * @param string $route
     * @param string $requestMethod
     */
    public function __construct($route, $requestMethod = self::REQUEST_METHOD_GET)
    {
        $this->setRoute($route);
        $this->setRequestMethod($requestMethod);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return Endpoint
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @param string $requestMethod
     * @return Endpoint
     * @throws ModelException
     */
    public function setRequestMethod($requestMethod = self::REQUEST_METHOD_GET)
    {
        switch ($requestMethod) {
            case self::REQUEST_METHOD_GET:
            case self::REQUEST_METHOD_POST:
            case self::REQUEST_METHOD_PUT:
            case self::REQUEST_METHOD_PATCH:
            case self::REQUEST_METHOD_DELETE:
                $this->requestMethod = $requestMethod;
                break;
            default:
                throw new ModelException(
                    sprintf('Unsupported request method \'%s\' for endpoint', $requestMethod)
                );
        }

        return $this;
    }
}
