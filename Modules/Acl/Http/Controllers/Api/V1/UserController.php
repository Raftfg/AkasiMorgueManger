<?php

namespace Modules\Acl\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Http\Resources\UserResource;
use Modules\Acl\Http\Resources\UsersResource;
use App\Http\Controllers\Api\V1\ApiController;
use Modules\Acl\Http\Requests\UserIndexRequest;
use Modules\Acl\Http\Requests\UserStoreRequest;
use Modules\Acl\Http\Requests\UserDeleteRequest;
use Modules\Acl\Http\Requests\UserUpdateRequest;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Acl\Repositories\UserRepository;
use Modules\Acl\Http\Requests\UserTeleverserRequest;
use Modules\Acl\Http\Requests\UserEnvoiNotificationRequest;

class UserController extends \Modules\Acl\Http\Controllers\AclController {
    use \Modules\Acl\Traits\EnvoiNotificationUserTrait;
    
    /**
     * @var PostRepository
     */
    protected $userRepositoryEloquent, $roleRepositoryEloquent;
    
    public function __construct(UserRepository $userRepositoryEloquent, RoleRepository $roleRepositoryEloquent) {
        parent::__construct();
        $this->userRepositoryEloquent = $userRepositoryEloquent;
        $this->roleRepositoryEloquent = $roleRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(UserIndexRequest $request)
    {
        $queryBuilder = filtre_recherche_builder($request->recherche, 
                $this->userRepositoryEloquent->getModel(), 
                $this->userRepositoryEloquent->query());
        $donnees = $queryBuilder->orderBy('created_at', 'DESC')->paginate($this->nombrePage);
        return new UsersResource($donnees);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        $attributs = $request->except(['tenant_id']);   //sanitinize
        $motDePasse = $request->password;
        $item = DB::transaction(function () use ($attributs) {
            $role = $this->roleRepositoryEloquent->findByUuid($attributs['role_id'])->first();
            $item = $this->userRepositoryEloquent->create($attributs);
            $item->assignRole($role->name);
            
            return $item;
        });
        $item = $item->fresh();
        
        $motDePasse = $motDePasse ?: "";
        $this->envoiInvitation($item, $motDePasse);
        
        return new UserResource($item);
    } 
        
   /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid)
    {
        $item = $this->userRepositoryEloquent->findByUuidOrFail($uuid)->first(); 
        return new UserResource($item);
    }
    
    /**
     * Téléverser le document
     * 
     * @param type $request
     * @param string $uuid
     */
    // public function televerser(UserTeleverserRequest $request, $uuid) {
    //     //\Log::info($uuid);
    //     $item = $this->userRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element ?
    //     $documents = $request->file('documents');
    //     //\Log::info($documents);
    //     $this->saveMediasApiTenant($item, $documents, $this->mediaCollectionName, $this->mediaDisk, null);
        
    //     $moduleAlias = strtolower(config('acl.name'));
    //     $media_collection_name = config("$moduleAlias.media_collection_name");
        
    //     return reponse_json_transform([
    //         'message'=> "Succes",
    //         'medias' => $item->obtenirMediaUrlsFormates($media_collection_name),
    //     ]);
    // }

   /**
     * Update a resource.
     *
     * @return Response
     */
    public function update(UserUpdateRequest $request, $uuid)
    {
        $user = $this->userRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        $attributs = $request->except(['tenant_id']);   //sanitinize
        $item = DB::transaction(function () use ($attributs, $user) {
            $role = $this->roleRepositoryEloquent->findByUuid($attributs['role_id'])->first();
            $item = $this->userRepositoryEloquent->modifier($attributs, $user);
            $item->syncRoles([$role->name]);
            
            return $item;
        });
        $item = $item->fresh();
        return new UserResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeleteRequest $request, $uuid)
    {
        $user = $this->userRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        //@TODO : Implémenter les conditions de suppression
            $this->userRepositoryEloquent->delete($user->id);
        
        $data = [
            "message" => $this->messageSuppressionPossibleOui,
        ];
        return reponse_json_transform($data);
    }    

    /**
     * Envoyer le mot de passe temporaire
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function genererMotPasseTemporaire(UserEnvoiNotificationRequest $request, $uuid)
    {
        $user = $this->userRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        $motDePasse = $this->userRepositoryEloquent->genererMotDePasseAleatoire($user);
        $motDePasse = $motDePasse ?: "";
        $this->envoiMotPasseTemporaire($user, $motDePasse);
        
        $data = [
            "message" => __("Envoyé avec succès"),
        ];
        return reponse_json_transform($data);
    }    
}
