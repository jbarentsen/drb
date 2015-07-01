<?php

namespace NcpBase\InputFilter\Address;

use Dws\Zend\InputFilter\InputFilter;

class AddressCreateInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            [
                'name' => 'city',
                'filters' => [
                    [
                        'name' => 'StringTrim'
                    ],
                    [
                        'name' => 'Zend\Filter\UpperCaseWords'
                    ]
                ],
            ]
        )
            ->add([
                'name' => 'street1',
                'required' => false,
            ])
            ->add([
                'name' => 'street2',
                'required' => false,
            ])
            ->add([
                'name' => 'street3',
                'required' => false,
            ])
            ->add([
                'name' => 'postcode',
                'filters' => [
                    [
                        'name' => 'Digits'
                    ],
                ],
            ])
            ->add([
                'name' => 'state',
                'filters' => [
                    [
                        'name' => 'StringToUpper'
                    ]
                ]
            ])
            ->add([
                'name' => 'country',
                'required' => false,
                'filters' => [
                    [
                        'name' => 'StringToUpper'
                    ]
                ]
            ]);
    }
}
