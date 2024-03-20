<?php

namespace Modules\Comptabilite\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AutorisationsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => AutorisationResource::collection($this->collection),
        ];
    }
}
