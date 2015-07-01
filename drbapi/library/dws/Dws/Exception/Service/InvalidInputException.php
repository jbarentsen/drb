<?php

namespace Dws\Exception\Service;

use Dws\Exception\ServiceException;
use Exception;

class InvalidInputException extends ServiceException
{
    /**
     * @var array
     */
    private $validationMessages;

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Construct the exception. Note: The message is NOT binary safe.
     * @link http://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     * @param array $validationMessages [optional] The validation messages.
     */
    public function __construct($message = "", $code = 0, Exception $previous = null, array $validationMessages = [])
    {
        parent::__construct($message, $code, $previous);
        $this->setValidationMessages($validationMessages);
    }

    /**
     * @return array
     */
    public function getValidationMessages()
    {
        return $this->validationMessages;
    }

    /**
     * @param array $validationMessages
     * @return InvalidInputException
     */
    public function setValidationMessages(array $validationMessages)
    {
        $this->validationMessages = $validationMessages;
        $this->message = var_export($validationMessages, true); // TODO: fix nasty workaround
        return $this;
    }
}
