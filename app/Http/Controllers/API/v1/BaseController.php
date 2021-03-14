<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseApiResponse;

/**
 * Class BaseController
 * @package App\Http\Controllers\API\v1
 */
abstract class BaseController extends Controller
{
    /** @var BaseApiResponse */
    protected BaseApiResponse $response;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->response = new BaseApiResponse();
    }
}
