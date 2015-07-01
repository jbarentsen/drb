<?php

namespace DwsAuth\Listener;

use Dws\Exception\Service\UnauthorizedException;
use DwsAuth\Adapter\HmacValidationAdapter;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class HmacValidationListener
{
    protected $adapter;

    /**
     * @param HmacValidationAdapter $adapter
     */
    public function __construct(HmacValidationAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param MvcEvent $event
     * @throws UnauthorizedException
     */
    public function __invoke(MvcEvent $event)
    {
        $result = $this->adapter->authenticate();
        if (!$result->isValid()) {
            throw new UnauthorizedException('Access denied to API because of invalid HMAC');
        }
    }
}