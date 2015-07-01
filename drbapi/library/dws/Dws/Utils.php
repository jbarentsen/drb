<?php

namespace Dws;

use Dws\Exception\InvalidArgumentException;
use stdClass;
use Traversable;
use Zend\Stdlib\ArrayUtils;

class Utils
{
    /**
     * Convert Traversable|stdClass to Array
     *
     * @param array|Traversable|stdClass $data
     * @return array
     * @throws InvalidArgumentException
     */
    public static function toArray($data)
    {
        if ($data instanceof Traversable) {
            $data = ArrayUtils::iteratorToArray($data);
        } elseif ($data instanceof stdClass) {
            $data = (array)$data;
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid data provided to %s; must be an array or Traversable',
                __METHOD__
            ));
        }
        return $data;
    }
}
