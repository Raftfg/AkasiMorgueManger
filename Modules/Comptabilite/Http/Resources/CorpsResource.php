<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class CorpsResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Exercice");
        return [
            'uuid' => $this->uuid,
            'nom_defunt' => $this->nom_defunt,
            'prenom_defunt' => $this->prenom_defunt,
            'date_naissance' => $this->date_naissance,
            'date_deces' => $this->date_deces,
            'lieu_deces' => $this->lieu_deces,
            'etat_corps' => $this->etat_corps,
            'cause_décès'=> $this->cause_décès,
            'morgue' => new MorgueResource($this->morgue),
            // 'budget' => new BudgetResource($this->budget),
            // 'user' => new UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            
            'acl' => $acl,
        ];
    }

}
