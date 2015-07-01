<?php

namespace Dws\Zend\Validator;

use Zend\Validator\AbstractValidator;

class IsArray extends AbstractValidator
{
    /**
     * Error codes
     * @const string
     */
    const NOT_ARRAY = 'notArray';

    /**
     * Error messages
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_ARRAY => 'The value is not an array',
    );

    /**
     * Returns true if the value is an array.
     *
     * @param  mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);

        if (!is_array($value)) {
            $this->error(self::NOT_ARRAY);
            return false;
        }

        return true;
    }
}
