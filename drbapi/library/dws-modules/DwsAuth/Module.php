<?php
namespace DwsAuth;

use Zend\Console\Console;
use Zend\Mvc\MvcEvent;
use ZF\MvcAuth\MvcAuthEvent;
use Doctrine\ORM\Mapping\Driver\XmlDriver;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        $app = $e->getParam('application');
        $sm = $app->getServiceManager();
        $config = $sm->get('Config');

        // Enable custom entities, based on zf-oauth-doctrine
        if (!(isset($config['zf-oauth2-doctrine']['storage_settings']['enable_default_entities'])
            && $config['zf-oauth2-doctrine']['storage_settings']['enable_default_entities'])
        ) {
            $chain = $sm->get($config['zf-oauth2-doctrine']['storage_settings']['driver']);
            $chain->addDriver(new XmlDriver(__DIR__ . '/config/orm'), 'ZF\OAuth2\Doctrine\Entity');
        }

        if (Console::isConsole()) {
            // Do not set the following Auth instances
            return;
        }

        // Wire in our listener at priority >1 to ensure it runs before the DefaultAuthorizationListener
        $eventManager->attach(
            MvcAuthEvent::EVENT_AUTHORIZATION,
            $sm->get('DwsAuth\Listener\AuthorizationListener'),
            100
        );

        // Wire in our listener at priority >1 to ensure it runs before the DefaultAuthorizationListener
        $eventManager->attach(
            MvcEvent::EVENT_DISPATCH,
            $sm->get('DwsAuth\Listener\HmacValidationListener'),
            100
        );

    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'invokables' => [
                //'DwsAuth\Listener\HmacValidationListener' => 'DwsAuth\Listener\HmacValidationListener'
            ],
            'factories' => [
                'DwsAuth\Adapter\HmacValidationAdapter' => 'DwsAuth\Adapter\HmacValidation\HmacValidationAdapterFactory',
                'DwsAuth\Listener\AuthorizationListener' => 'DwsAuth\Listener\Authorization\AuthorizationListenerFactory',
                'DwsAuth\Listener\HmacValidationListener' => 'DwsAuth\Listener\HmacValidation\HmacValidationListenerFactory'
            ],
        ];
    }


}