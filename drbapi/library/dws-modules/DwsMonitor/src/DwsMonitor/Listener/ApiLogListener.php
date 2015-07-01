<?php

namespace DwsMonitor\Listener;

use DwsMonitor\Service\MonitorService;
use ZF\ContentNegotiation\Request;
use Zend\Mvc\MvcEvent;

class ApiLogListener
{
    /*
     * @var array
     */
    private $config;
    /*
    * @var MonitorService
    */
    private $monitor;

    public function __construct(array $config, MonitorService $monitor)
    {
        $this->config = $config;
        $this->monitor = $monitor;
    }

    /**
     * @param MvcEvent $event
     * @return null
     */
    public function __invoke(MvcEvent $event)
    {
        /** @var Request $request */
        $request = $event->getRequest();
        $method = $request->getMethod();

        $allowedMethods = $this->config['methods'];
        if (!in_array($method, $allowedMethods)) {
            return;
        }
        $extra = [];
        $extra['path'] = urldecode($request->getRequestUri());
        $extra['headers'] = $request->getHeaders()->toArray();
        $extra['content'] = $request->getContent();
        $message = sprintf('%s request to %s', $method, $extra['path']);
        $this->monitor->info($message, $extra);
    }
}