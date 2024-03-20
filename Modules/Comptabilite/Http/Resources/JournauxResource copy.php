<?php

namespace Modules\Comptabilite\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JournauxResource extends ResourceCollection
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
            'data' => JournalResource::collection($this->collection),
        ];
    }
}
