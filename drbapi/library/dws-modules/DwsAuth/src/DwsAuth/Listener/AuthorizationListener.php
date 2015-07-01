<?php

namespace DwsAuth\Listener;

use NcpUser\Service\UserService;
use Zend\Authentication\AuthenticationService;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use ZF\MvcAuth\MvcAuthEvent;

class AuthorizationListener
{

    /**
     * @var AuthenticationService $authenticationService
     */
    private $authenticationService;

    /**
     * @var  UserService $userService
     */
    private $userService;

    public function __construct(AuthenticationService $authenticationService, UserService $userService)
    {
        $this->authenticationService = $authenticationService;
        $this->userService = $userService;
    }

    /**
     * @param MvcAuthEvent $mvcAuthEvent
     * @throws \Dws\Exception\Service\ModelNotFoundException
     */
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        // Add validated identity to ZfcUser storage
        $identity = $mvcAuthEvent->getIdentity();
        if ($identity instanceof AuthenticatedIdentity) {
            /** var AuthenticatedIdentity $identity */
            $user = $this->userService->find($identity->getAuthenticationIdentity()['user_id']);
            if ($user) {
                // It should not be possible to be authenticated without valid user, but in that case
                // we simply don't set the identity to the authentication service. No permissions
                // will then be granted.
                $this->authenticationService->getStorage()->write($user);
            }

        }
    }
}