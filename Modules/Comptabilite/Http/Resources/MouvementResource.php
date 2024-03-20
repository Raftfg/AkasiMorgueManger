<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class MouvementResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Mouvement");
        return [
            'uuid' => $this->uuid,
            'date_heure_depart' => $this->date_heure_depart,
            'Lieu_Départ' => $this->Lieu_Départ,
            'date_heure_arrivee' => $this->date_heure_arrivee,
            'lieu_arrivee' => $this->lieu_arrivee,
            'responsable_mouvement' => $this->responsable_mouvement,
            'corps' => new CorpsResource($this->corps),
            // 'user' => new UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            'acl' => $acl,
        ];
    }

}
