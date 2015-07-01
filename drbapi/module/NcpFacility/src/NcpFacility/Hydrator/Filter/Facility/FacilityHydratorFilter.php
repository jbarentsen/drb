<?php

namespace NcpFacility\Hydrator\Filter\Facility;

use NcpBase\Hydrator\Filter\BaseHydratorFilter;

class FacilityHydratorFilter extends BaseHydratorFilter
{
    /**
     * Should return true, if the given filter
     * does not match
     *
     * @param string $property The name of the property
     * @return bool
     */
    public function filter($property)
    {
        return (
            parent::filter($property)
        );
    }
}
