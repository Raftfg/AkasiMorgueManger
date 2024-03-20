<?php

namespace Modules\Acl\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Acl\Http\Resources\PermissionsResource;
use Modules\Acl\Repositories\PermissionRepository;

class PermissionController extends \Modules\Acl\Http\Controllers\AclController {

    /**
     * @var PostRepository
     */
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository) {
        parent::__construct();
        $this->permissionRepository = $permissionRepository;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $donnees = $this->permissionRepository->all();
        return new PermissionsResource($donnees);
    }
    
}
