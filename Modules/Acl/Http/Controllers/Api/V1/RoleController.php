<?php

namespace Modules\Acl\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Acl\Http\Resources\RolesResource;
use Modules\Acl\Http\Resources\RoleResource;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Acl\Http\Requests\RoleStoreRequest;
use Modules\Acl\Http\Requests\RoleUpdateRequest;
use Modules\Acl\Http\Requests\RoleDeleteRequest;
use Modules\Acl\Http\Requests\RoleIndexRequest;

class RoleController extends \Modules\Acl\Http\Controllers\AclController {

    /**
     * @var PostRepository
     */
    protected $roleRepositoryEloquent;

    public function __construct(RoleRepository $roleRepositoryEloquent) {
        parent::__construct();
        $this->roleRepositoryEloquent = $roleRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RoleIndexRequest $request)
    {
        $queryBuilder = filtre_recherche_builder($request->recherche, 
                $this->roleRepositoryEloquent->getModel(), 
                $this->roleRepositoryEloquent->query());
        $donnees = $queryBuilder->whereNonSuperAdmin()->orderBy('created_at', 'DESC')->paginate($this->nombrePage);
        return new RolesResource($donnees);
    }    
     /**
     * Show a resource.
     * 
     * @return Response
     */
    public function show(RoleIndexRequest $request, $uuid)
    {
        $item = $this->roleRepositoryEloquent->findByUuidOrFail($uuid)->first(); 
        return new RoleResource($item);
    }

   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(RoleStoreRequest $request)
    {
        $item = $this->roleRepositoryEloquent->creerRole($request->all());
        $item = $item->fresh();
        return new RoleResource($item);
    }
    
   /**
     * Update a resource.
     *
     * @return Response
     */
    public function update(RoleUpdateRequest $request, $uuid)
    {
        $this->roleRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        $item = $this->roleRepositoryEloquent->majRole($uuid, $request->all());
        $item = $item->fresh();
        return new RoleResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleDeleteRequest $request, $uuid)
    {
        $role = $this->roleRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        //@TODO : Implémenter les conditions de suppression
            $this->roleRepositoryEloquent->delete($role->id);
        
        $data = [
            "message" => $this->messageSuppressionPossibleOui,
        ];
        return reponse_json_transform($data);
    }
    
   /**
     * Lister les rôles internes.
     *
     * @return Response
     */
    public function roleInternes(RoleIndexRequest $request)
    {
        $donnees = $this->roleRepositoryEloquent->interne()->whereNonSuperAdmin()->get();
        return new RolesResource($donnees);
    }
    
   /**
     * Lister les rôles externes.
     *
     * @return Response
     */
    public function roleExternes(RoleIndexRequest $request)
    {
        $donnees = $this->roleRepositoryEloquent->externe()->get();
        return new RolesResource($donnees);
    }
}
