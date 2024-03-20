<?php

namespace Modules\Acl\Http\Resources;

use Modules\Acl\Http\Resources\RoleResource;

class UserResource extends \App\Http\Resources\BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $acl = $this->displayAcl("User");
        $moduleAlias = strtolower(config('acl.name'));
        $media_collection_name = config("$moduleAlias.media_collection_name");

        if(user_api()->isSuper() || $this->id != user_api()->id){
            $acl['delete'] = false;
        }
        return [
            'uuid' => $this->uuid,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'tel' => $this->tel,
            'roles' => RoleResource::collection($this->roles),
            // 'role_nom' => implode(', ', $this->roles()->pluck('display_name')->toArray()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'medias' => $this->obtenirMediaUrlsFormates($media_collection_name),
            
            'acl' => $acl,
        ];
    }

}
