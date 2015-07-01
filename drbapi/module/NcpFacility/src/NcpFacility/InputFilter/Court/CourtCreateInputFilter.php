<?php

namespace NcpFacility\InputFilter\Court;

use NcpFacility\Model\Facility;
use Dws\Exception\Service\ModelNotFoundException;
use Dws\Exception\Service\UnauthorizedException;
use Dws\Zend\InputFilter\InputFilter;
use Exception;
use InvalidArgumentException;
use NcpFacility\Service\FacilityService;
use Zend\Validator\Callback;

class CourtCreateInputFilter extends InputFilter
{

    /**
     * @var FacilityService $facilityService
     */
    private $facilityService;

    /**
     * @var Callback
     */
    private $facilityValidator;

    /**
     * Constructor
     *
     * @param FacilityService $facilityService
     * @throws InvalidArgumentException
     *
     * */
    public function __construct(
        FacilityService $facilityService
    ) {
        $this->facilityService = $facilityService;

        $this->add(
            [
                'name' => 'name',
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ],
                ],
            ]
        );
        $this->facilityValidator = new Callback(function ($value) {
            if ($value instanceof Facility) {
                return true;
            } else if (!(is_array($value) && isset($value['id']))) {
                $this->facilityValidator->setMessage('No valid identifier specified');
                return false;
            }

            try {
                $this->facilityService->find($value);
                return true;
            } catch (ModelNotFoundException $e) {
                $this->facilityValidator->setMessage($e->getMessage());
            } catch (UnauthorizedException $e) {
                $this->facilityValidator->setMessage($e->getMessage());
            } catch (Exception $e) {
                $this->facilityValidator->setMessage('Unknown error during validation');
            }
            return false;
        });
        $this->add(
            [
                'name' => 'facility',
                'validators' => [
                    $this->facilityValidator
                ]
            ]
        );

    }
}
