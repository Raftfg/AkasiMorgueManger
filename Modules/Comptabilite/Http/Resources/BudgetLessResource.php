<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class BudgetLessResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Budget");
        return [
            'uuid' => $this->uuid,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            // 'user' => new UserResource($this->user),
            'exercice' => new ExerciceResource($this->exercice),
            // 'lignes' => new LignesResource($this->lignes),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            
            'acl' => $acl,
        ];
    }

}
