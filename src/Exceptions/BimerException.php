<?php

namespace Bimer\Exceptions;

use Exception;

class BimerException extends Exception
{
    /**
     * @var string|int|null
     */
    protected $errorCode;

    /**
     * @param string|null $message
     * @param string|int|null $errorCode
     */
    public function __construct(string $message = null, $errorCode = null)
    {
        $message = $message ? trim($message) : 'Undefined error';

        $this->errorCode = $errorCode;

        parent::__construct($message);
    }

    /**
     * @return int|string|null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
