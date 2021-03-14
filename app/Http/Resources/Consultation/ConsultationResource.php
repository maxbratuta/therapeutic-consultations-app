<?php

namespace App\Http\Resources\Consultation;

use App\DomainServices\ConsultationService;
use App\Models\Consultation;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ConsultationResource
 * @package App\Http\Resources\Consultation
 */
class ConsultationResource extends JsonResource
{
    /** @var Consultation */
    public $resource;

    /** @var ConsultationService */
    private ConsultationService $consultationService;

    /**
     * ConsultationResource constructor.
     *
     * @param Consultation $resource
     * @throws BindingResolutionException
     */
    public function __construct(Consultation $resource)
    {
        $this->consultationService = app()->make(ConsultationService::class);

        parent::__construct($resource);
    }

    /**
     * @param null $request
     * @return array
     */
    public function toArray($request = null): array
    {
        return [
            'id' => $this->resource->id,
            'content' => $this->resource->user->name,
            'start' => $this->resource->start_at,
            'end' => $this->resource->end_at,
            'type' => ConsultationService::ELEMENT_DISPLAY_TYPE_BACKGROUND,
            'style' => $this->consultationService->getDefaultTimeLineStyles(),
        ];
    }
}
