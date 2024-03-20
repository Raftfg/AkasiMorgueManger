<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class ExamenResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Examen");
        return [
            'uuid' => $this->uuid,
            'date_examen' => $this->date_examen,
            'resultat_examen' => $this->resultat_examen	,
            'medecin' => $this->medecin,
            // 'user' => new UserResource($this->user),
            'corps' => new CorpsResource($this->corps),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'acl' => $acl,
        ];
    }

}
