<?php

namespace Dws\DoctrineModule\Stdlib\Hydrator\Strategy;

use DateTime;
use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

class DateStrategy extends DefaultStrategy
{
    /**
     * {@inheritdoc}
     *
     * Convert a string value into a DateTime object
     */
    public function hydrate($value)
    {
        if (is_string($value)) {
            $value = new DateTime($value);
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * Convert a DateTime object into a string Y-m-d
     */
    public function extract($value)
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $value;
    }
}