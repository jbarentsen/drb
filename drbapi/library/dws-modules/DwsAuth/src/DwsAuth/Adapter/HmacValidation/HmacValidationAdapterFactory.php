<?php

namespace DwsAuth\Adapter\HmacValidation;

use DwsAuth\Adapter\HmacValidationAdapter;
use NcpUser\Service\UserService;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceLocatorInterface;

class HmacValidationAdapterFactory
{

    /**
     * @param ServiceLocatorInterface $services
     * @return HmacValidationAdapter
     */
    public function __invoke(ServiceLocatorInterface $services)
    {
        /** @var Request $request */
        $request = $services->get('Request');

        /**
         * @TODO: This should not be a UserService, but an ApiClientService, as the keys
         * are depending on the sending party (mobile, etc), not an actual user. For
         * development purpose UserService is initially being used
         * @var UserService $service
         */
        $service = $services->get('NcpUser\Service\User');

        return new HmacValidationAdapter($request, $service);
    }
}