<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class BaseApiCollection
 * @package App\Http\Resources
 */
abstract class BaseApiCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $dirtyData = $this->resource->toArray();

        if (isset($dirtyData['data'])) {
            return [
                'items' => $dirtyData['data']
            ];
        } else {
            return parent::toArray($request);
        }
    }
}
