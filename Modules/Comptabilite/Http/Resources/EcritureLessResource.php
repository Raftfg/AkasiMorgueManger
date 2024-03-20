<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class EcritureLessResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Ecriture");
        return [
            'uuid' => $this->uuid,
            'libelle' => $this->libelle,
            'montant' => $this->montant,
            'description' => $this->description,
            'taxe' => $this->taxe,
            'date' => $this->date,
            // 'user' => new UserResource($this->user),
            // 'exercice' => new ExerciceResource($this->exercice),
            // 'devise' => new DeviseResource($this->devise),
            // 'journal' => new JournalResource($this->journal),
            // 'ligne' => new LigneResource($this->ligne),
            // 'compte_debit' => new SaccountResource($this->compte_debit),
            // 'compte_credit' => new SaccountResource($this->compte_credit),
            // 'document' => new DocumentResource($this->document),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            
            'acl' => $acl,
        ];
    }

}
