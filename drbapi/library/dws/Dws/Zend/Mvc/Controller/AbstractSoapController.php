<?php

namespace Dws\Zend\Mvc\Controller;

use Dws\Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;
use Zend\Uri\Http;

abstract class AbstractSoapController extends AbstractActionController
{
    /**
     * @param MvcEvent $e
     * @return void
     */
    public function onDispatch(MvcEvent $e)
    {
        /** @var Http $uri */
        $uri = $this->getRequest()->getUri();
        $port = $uri->getPort();
        $uriFull = sprintf('%s://%s%s%s',
            $uri->getScheme(),
            $uri->getHost(),
            ($port !== 80 ? ':' . $port : ''),
            $uri->getPath()
        );

        $wsdl = $this->params()->fromQuery('wsdl');
        if (isset($wsdl)) {
            $this->handleWsdl($uriFull);
        } else {
            $this->handleSoap($uriFull);
        }

        return $this->getResponse();
    }

    /**
     * @param string $uri
     * @throws Exception
     */
    private function handleWsdl($uri)
    {

        // We need to cache the WSDL here!!!

        $autoDiscover = new AutoDiscover();
        $autoDiscover
            ->setClass($this->getHandler())
            ->setUri($uri);

        $wsdl = $autoDiscover->generate();

        header('Content-Type: application/xml');
        echo $wsdl->toXml();
    }

    /**
     * @param string $uri
     * @throws Exception
     */
    private function handleSoap($uri)
    {
        /** @var Server $soapServer */
        $soapServer = new Server(
            null,
            [
                'wsdl' => $uri . '?wsdl'
            ]
        );

        $soapServer->setClass($this->getHandler());
        $soapServer->handle();
    }

    /**
     * @return object
     * @throws Exception
     */
    abstract protected function getHandler();
}
