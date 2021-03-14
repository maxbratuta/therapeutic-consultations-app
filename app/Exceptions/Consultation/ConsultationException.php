<?php

namespace App\Exceptions\Consultation;

use App\Exceptions\BaseException;

/**
 * Class ConsultationException
 * @package App\Exceptions\Consultation
 */
class ConsultationException extends BaseException
{
    /**
     * @param $message
     * @return static
     */
    public static function failInsert($message): self
    {
        return new self($message, 500, null, null);
    }
}
