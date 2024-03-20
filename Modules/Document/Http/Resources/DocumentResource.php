<?php

namespace Modules\Comptabilite\Http\Resources;

class DocumentResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Document");
        return [
            'uuid' => $this->uuid,
            'name' => $this->type,
            'file_name' => $this->status,
            'file_path' => $this->start_date,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            'acl' => $acl,
        ];
    }

}
