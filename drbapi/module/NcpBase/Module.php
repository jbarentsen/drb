<?php

namespace NcpBase;

use Dws\Exception\Service\UnauthorizedException;
use Zend\Console\Console;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(
            'dispatch.error',
            [
                $this,
                'handleDispatchErrors'
            ],
            -3000
        );
    }

    /**
     * @param MvcEvent $e
     * @return void|ViewModel
     */
    public function handleDispatchErrors(MvcEvent $e)
    {
        $exception = $e->getParam('exception');
        $routeMatch = $e->getRouteMatch();
        if (!$routeMatch || $exception instanceof UnauthorizedException) {
            // We don't handle permissions errors or unmatched routes
            return;
        }

        // We will do the final handling here
        $e->stopPropagation();

        if (Console::isConsole()) {
            return;
        }
        $error = $e->getError();
        $model = new ViewModel(
            [
                'message' => 'An error occurred. Good luck!<br/><br/><pre>' . $exception->getMessage() . '</pre>',
                'reason' => $error,
                'exception' => $exception,
            ]
        );
        $model->setTemplate('error/404');
        $e->getViewModel()->addChild($model);

        $response = $e->getResponse();
        $response->setStatusCode(404);

        return $model;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        $options = [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
        if (file_exists(__DIR__ . '/../../autoload_classmap.php')) {
            $options['Zend\Loader\ClassMapAutoloader'] = [
                __DIR__ . '/../../autoload_classmap.php',
            ];
        }
        return $options;
    }

    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'sidebarprogress' => 'NcpBase\View\Helper\SidebarProgressHelper',
            ],
        ];
    }

    public function getHydratorConfig()
    {
        return [
            'factories' => [
                'NcpBase\Hydrator\Model\Base' =>
                    'NcpBase\Hydrator\Model\Base\BaseHydratorFactory',
                'NcpBase\Hydrator\Model\Identifier' =>
                    'NcpBase\Hydrator\Model\Identifier\IdentifierHydratorFactory',
            ]
        ];
    }

    public function getServiceConfig()
    {
        return [
            'invokables' => [],
            'factories' => []
        ];
    }
}
