<?php

namespace NcpBase\InputFilter\Address;

class AddressPopulateInputFilter extends AddressCreateInputFilter
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
                    ['name' => 'Digits'],
                ],
            ]
        );
    }
}