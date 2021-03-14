<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Support\Arr;

/**
 * Class BaseApiResponse
 * @package App\Http\Responses
 */
class BaseApiResponse extends Response
{
    /** @var array|null[] */
    protected array $template = [
        'status' => null,
        'data' => null,
        'errors' => null,
        'notify' => null
    ];

    /**
     * @param $data
     * @param null $notify
     * @return BaseApiResponse
     */
    public function data($data, $notify = null): BaseApiResponse
    {
        $this->template['status'] = $this->isSuccessful();
        $this->template['data'] = $data;
        $this->template['notify'] = $notify;

        return $this->setContent($this->template);
    }

    /**
     * @param $error
     * @param null $notify
     * @return BaseApiResponse
     */
    public function error($error, $notify = null): BaseApiResponse
    {
        if ($this->isSuccessful()) {
            $this->statusCode = self::HTTP_BAD_REQUEST;
        }

        $this->template['status'] = false;

        if ($error) {
            $this->template['errors'] = is_string($error) ? ['global' => [$error]] : $this->transformDotsToArrayErrors($error);
        }

        $this->template['notify'] = $notify;

        return $this->setContent($this->template);
    }

    /**
     * Method transforms dots to array errors.
     *
     * @param array $dirtyErrors
     * @return array
     */
    protected function transformDotsToArrayErrors(array $dirtyErrors): array
    {
        $errors = [];

        foreach ($dirtyErrors as $key => $value) {
            Arr::set($errors, $key, $value);
        }

        return $errors;
    }
}
