<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class AutorisationResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Autorisation");
        return [
            'uuid' => $this->uuid,
            'date_autorisation' => $this->date_autorisation,
            'Nom_autorisant' => $this->Nom_autorisant,
            'type_autorisation' => $this->type_autorisation,
            'corps' => new CorpsResource($this->corps),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            'acl' => $acl,
        ];
    }

}
