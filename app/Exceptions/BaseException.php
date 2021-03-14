<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class BaseException
 * @package App\Exceptions
 */
abstract class BaseException extends Exception
{
    /**
     * BaseException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
