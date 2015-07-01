<?php

namespace Dws\Zend\InputFilter;

use Dws\Utils;
use stdClass;
use Traversable;
use Zend\InputFilter\InputFilter as BaseInputFilter;
use Dws\Exception\InvalidArgumentException;
use Zend\InputFilter\InputFilterInterface;

class InputFilter extends BaseInputFilter
{
    /**
     * Overridden to allow for using stdClass
     *
     * @param array|Traversable|stdClass $data
     * @return InputFilterInterface
     * @throws InvalidArgumentException
     */
    public function setData($data)
    {
        if ($data instanceof stdClass) {
            $data = Utils::toArray($data);
        }
        parent::setData($data);

        return $this;
    }
}
