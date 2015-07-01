<?php

namespace NcpFacility\InputFilter\Facility;

class FacilityPopulateInputFilter extends FacilityCreateInputFilter
{
    /**
     * Constructor
     *
     */
    public function __construct() {
        parent::__construct();

        $this->add(
            [
                'name' => 'id',
                'filters' => [
                    [
                        'name' => 'digits'
                    ],
                ],
            ]
        );
        $this->add(
            [
                'name' => 'address',
                'required' => false,
            ]
        );
    }
}
