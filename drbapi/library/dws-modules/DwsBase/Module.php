<?php

namespace DwsBase;

use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $em = $application->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleError']);
        $em->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'handleError']);
    }

    /**
     *
     * @param MvcEvent $e
     */
    public function handleError(MvcEvent $e)
    {
        $exception = $e->getParam('exception');
        $serviceManager = $e->getApplication()->getServiceManager();
        $monitor = $serviceManager->get('DwsMonitor\Service\MonitorService');
        if (is_object($exception)) {
            $monitor->err(
                $exception->getMessage(),
                [
                    'file' => $exception->getFile(),
                    'line_nr' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );
        } else {
            $monitor->err(
                $e->getError(),
                [
                    'file' => __FILE__,
                    'line_nr' => 0,
                    'trace' => '',
                ]
            );
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
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

    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                // Inspired by
                // https://www.coderprofile.com/coder/benparish/blog/39/php-overriding-zend-framework-2-form-elements-to-render-with-bootstrap-3-styling
                // Advanced examples, but ugly code at:
                // http://devincharge.com/bootstrapping-zf2-Form/
                'formelementerrors' => 'DwsBase\View\Helper\FormElementErrorHelper',
                'formrow' => 'DwsBase\View\Helper\FormRowHelper',
                'formelement' => 'DwsBase\View\Helper\FormElementHelper'
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'invokables' => [
                'translator' => '\stdClass' // Workaround for call in ZfSimpleMigrations::onBootstrap()
            ]
        ];
    }
}
