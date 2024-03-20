<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class ExerciceResource extends \App\Http\Resources\BaseResource {

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
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'statut' => $this->statut,
            // 'budget' => new BudgetResource($this->budget),
            'parametre' => new ParametreResource($this->parametre),
            // 'user' => new UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            
            'acl' => $acl,
        ];
    }

}
