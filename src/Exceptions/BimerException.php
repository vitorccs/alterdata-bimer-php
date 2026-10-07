<?php
declare(strict_types=1);

namespace Bimer\Exceptions;

use Exception;

class BimerException extends Exception
{
    public function __construct(?string                   $message = null,
                                protected string|int|null $errorCode = null)
    {
        parent::__construct($message ? trim($message) : 'Undefined error');
    }

    public function getErrorCode(): string|int|null
    {
        return $this->errorCode;
    }
}
