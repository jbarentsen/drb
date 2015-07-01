<?php

namespace NcpFacility\InputFilter\Facility;

use Dws\Exception\Service\ModelNotFoundException;
use Dws\Exception\Service\UnauthorizedException;
use Dws\Zend\InputFilter\HierarchicalInputFilter;
use NcpBase\InputFilter\Address\AddressCreateInputFilter;
use NcpOrganisation\Model\Club;
use NcpOrganisation\Service\ClubService;
use Exception;
use Zend\Validator\Callback;

class FacilityCreateInputFilter extends HierarchicalInputFilter
{

    /**
     * Constructor
     *
     */
    public function __construct()
    {
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

        $this->add(
            [
                'name' => 'address',
            ]
        );
        $this->addNested('address', new AddressCreateInputFilter());
    }
}
