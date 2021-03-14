<?php

namespace App\Http\Controllers\API\v1;

use App\ApplicationServices\ConsultationAppService;
use App\DomainServices\ConsultationService;
use App\Exceptions\Consultation\ConsultationException;
use App\Http\Requests\Consultation\ConsultationStoreRequest;
use App\Http\Resources\Consultation\ConsultationResource;
use App\Http\Responses\BaseApiResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

/**
 * Class ConsultationController
 * @package App\Http\Controllers\API\v1
 */
class ConsultationController extends BaseController
{
    /** @var ConsultationService */
    private ConsultationService $consultationService;

    /**
     * ConsultationController constructor.
     *
     * @param ConsultationService $consultationService
     */
    public function __construct(ConsultationService $consultationService)
    {
        $this->consultationService = $consultationService;

        parent::__construct();
    }

    /**
     * @param Request $request
     * @return BaseApiResponse
     */
    public function index(Request $request): BaseApiResponse
    {
        return $this->response->data($this->consultationService->getAllConsultations($request));
    }

    /**
     * @param ConsultationStoreRequest $request
     * @return BaseApiResponse
     * @throws BindingResolutionException
     */
    public function store(ConsultationStoreRequest $request): BaseApiResponse
    {
        try {
            return $this->response->data((new ConsultationResource($this->consultationService->store($request->validated()))));
        } catch (ConsultationException $e) {
            return $this->response->error($e->getMessage());
        }
    }
}
