<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class LigneLessResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Ligne");
        return [
            'uuid' => $this->uuid,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            'montant' => $this->montant,
            // 'user' => new UserResource($this->user),
            // 'budget' => new BudgetLessResource($this->budget),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            
            'acl' => $acl,
        ];
    }

}
