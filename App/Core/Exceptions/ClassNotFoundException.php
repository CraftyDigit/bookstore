<?php

namespace App\Core\Exceptions;

use Exception;

class ClassNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null, string $className = null)
    {
        if (null === $message) {
            if (null === $className) {
                $message = 'Class not found.';
            } else {
                $message = sprintf('Class "%s" could not be found.', $className);
            }
        }

        parent::__construct($message, $code, $previous);
    }
}