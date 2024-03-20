<?php

namespace Modules\Comptabilite\Http\Resources;

class SaccountClassResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("SaccountClass");
        return [
            'uuid' => $this->uuid,
            'num' => $this->num,
            'libelle' => $this->libelle,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,            
            'acl' => $acl,
        ];
    }

}
