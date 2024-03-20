<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class SaccountResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Saccount");
        return [
            'uuid' => $this->uuid,
            'num' => $this->num,
            'libelle' => $this->libelle,
            'parent' => $this->saccount,
            'classe' => $this->saccountclass,
            // 'description' => $this->description,
            // 'user' => new UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,            
            'acl' => $acl,
        ];
    }

}
