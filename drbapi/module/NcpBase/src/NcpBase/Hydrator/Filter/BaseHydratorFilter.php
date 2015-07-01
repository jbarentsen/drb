<?php

namespace NcpBase\Hydrator\Filter;

use Zend\Stdlib\Hydrator\Filter\FilterInterface;

class BaseHydratorFilter implements FilterInterface
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
            $property !== 'createdAt' &&
            $property !== 'updatedAt'
        );
    }
}
