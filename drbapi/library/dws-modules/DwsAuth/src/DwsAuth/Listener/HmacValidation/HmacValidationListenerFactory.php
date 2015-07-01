<?php

namespace DwsAuth\Listener\HmacValidation;

use DwsAuth\Adapter\HmacValidationAdapter;
use DwsAuth\Listener\HmacValidationListener;
use Zend\ServiceManager\ServiceLocatorInterface;

class HmacValidationListenerFactory
{

    /**
     * @param ServiceLocatorInterface $services
     * @return HmacValidationListener
     */
    public function __invoke(ServiceLocatorInterface $services)
    {
        /**
         * @var HmacValidationAdapter $hmacValidationAdapter
         */
        $hmacValidationAdapter = $services->get('DwsAuth\Adapter\HmacValidationAdapter');
        return new HmacValidationListener($hmacValidationAdapter);
    }
}