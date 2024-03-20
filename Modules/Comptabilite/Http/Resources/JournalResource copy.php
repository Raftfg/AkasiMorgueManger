<?php

namespace Modules\Comptabilite\Http\Resources;

use Modules\Acl\Http\Resources\UserResource;

class JournalResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("Journal");
        return [
            'uuid' => $this->uuid,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            // 'user' => new UserResource($this->user),
            'ecritures' => new EcrituresLessResource($this->ecritures),
            'compte_debit' => new SaccountResource($this->compte_debit),
            'compte_credit' => new SaccountResource($this->compte_credit),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            
            'acl' => $acl,
        ];
    }

}
