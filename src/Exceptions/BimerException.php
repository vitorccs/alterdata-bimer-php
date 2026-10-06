<?php

namespace Bimer\Exceptions;

use Exception;

class BimerException extends Exception
{
    protected string|int|null $errorCode;

    public function __construct(?string $message = null,
                                string|int|null $errorCode = null)
    {
        $message = $message ? trim($message) : 'Undefined error';

        $this->errorCode = $errorCode;

        parent::__construct($message);
    }

    public function getErrorCode(): int|string|null
    {
        return $this->errorCode;
    }
}
