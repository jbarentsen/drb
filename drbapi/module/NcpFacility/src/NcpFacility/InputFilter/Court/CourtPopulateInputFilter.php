<?php

namespace NcpFacility\InputFilter\Court;

use NcpFacility\Service\FacilityService;
use NcpOrganisation\Model\Organisation;

class CourtPopulateInputFilter extends CourtCreateInputFilter
{
    /**
     * Constructor
     *
     * @param FacilityService $facilityService
     */
    public function __construct(
        FacilityService $facilityService
    ) {
        parent::__construct($facilityService);

        $this->add(
            [
                'name' => 'id',
                'filters' => [
                    [
                        'name' => 'Digits'
                    ],
                ],
            ]
        );
    }
}
