<?php

namespace App\Http\Requests\Consultation;

use App\Http\Requests\BaseRequest;

/**
 * Class ConsultationStoreRequest
 * @package App\Http\Requests\Consultation
 */
class ConsultationStoreRequest extends BaseRequest
{
    /**
     * Method returns the rules.
     *
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'string']
        ];
    }
}
