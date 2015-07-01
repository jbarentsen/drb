<?php

namespace DwsApi\Controller\Console;

use DwsApi\Service\EndpointService;
use Exception;
use NcpPerson\Model\Person;
use Zend\Mvc\Controller\AbstractActionController;

class EndpointController extends AbstractActionController
{
    /**
     * @var EndpointService
     */
    private $endpointService;

    /**
     * Constructor
     *
     * @param EndpointService $endpointerService
     */
    public function __construct(EndpointService $endpointerService)
    {
        $this->endpointService = $endpointerService;
    }

    public function updateAction()
    {
        try {
            $this->endpointService->update();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
