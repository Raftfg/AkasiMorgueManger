<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Resources\SaccountClassResource;
use Modules\Comptabilite\Http\Resources\SaccountClassesResource;
use Modules\Comptabilite\Http\Requests\SaccountClassRequest;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\SaccountClassRepositoryEloquent;

class SaccountClassController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $saccountClassRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(SaccountClassRepositoryEloquent $saccountClassRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) {
        parent::__construct();
        $this->saccountClassRepositoryEloquent = $saccountClassRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $donnees = $this->saccountClassRepositoryEloquent->get();
        return new SaccountClassesResource($donnees);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) {
        $item = $this->saccountClassRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        return new SaccountClassResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(SaccountClassRequest $request)
    {
        $attributs = $request->all();

        $item = DB::transaction(function () use ($attributs) {
            // $user = $this->userRepositoryEloquent->findByUuid($attributs['user_id'])->first();
            $attributs['user_id'] = user_api()->id;

            $item = $this->saccountClassRepositoryEloquent->create($attributs);

            return $item;
        });

        $item = $item->fresh();

        return new SaccountClassResource($item);
    }
    
   /**
     * Update a resource.
     *
     * @return Response
     */
    public function update(SaccountClassRequest $request, $uuid)
    {
        $item = $this->saccountClassRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        $attributs = $request->all();

        // $user = $this->userRepositoryEloquent->findByUuid($attributs['user_id'])->first();
        $attributs['user_id'] = user_api()->id;

        $item = $this->saccountClassRepositoryEloquent->update($attributs, $item->id);
        $item = $item->fresh();
        return new SaccountClassResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $data = [
            "message" => __("Impossible de supprimer une classe de compte"),
            "resultat" => __(0),
        ];
        return reponse_json_transform($data);
    }    
}
