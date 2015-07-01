<?php

namespace DwsAuth\Listener\Authorization;

use DwsAuth\Listener\AuthorizationListener;
use NcpUser\Service\UserService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorizationListenerFactory
{
    /**
     * @param ServiceLocatorInterface $services
     * @return AuthorizationListener
     */
    public function __invoke(ServiceLocatorInterface $services)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $services->get('zfcuser_auth_service');

        /** @var UserService $userService */
        $userService = $services->get('NcpUser\Service\User');

        return new AuthorizationListener($authenticationService, $userService);
    }
}