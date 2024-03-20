<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Requests\LigneRequest;
use Modules\Comptabilite\Http\Resources\LigneResource;
use Modules\Comptabilite\Http\Resources\LignesResource;
use Modules\Comptabilite\Repositories\LigneRepositoryEloquent;
use Modules\Comptabilite\Repositories\BudgetRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;

class LigneController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $ligneRepositoryEloquent, $budgetRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(LigneRepositoryEloquent $ligneRepositoryEloquent, BudgetRepositoryEloquent $budgetRepositoryEloquent , UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->userRepositoryEloquent = $userRepositoryEloquent;
        $this->ligneRepositoryEloquent = $ligneRepositoryEloquent;
        $this->budgetRepositoryEloquent = $budgetRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $donnees = $this->ligneRepositoryEloquent->orderBy('id', 'DESC')->get();
        return new LignesResource($donnees);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->ligneRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Ligne non trouvée"),
            ];
            return reponse_json_transform($data);
        }
        return new LigneResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(LigneRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;

                if(isset($attributs['budget_id'])) {
                    $budget = $this->budgetRepositoryEloquent->findByUuid($attributs['budget_id'])->first();
                    $attributs['budget_id'] = $budget->id;
                }

                $item = $this->ligneRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            return new LigneResource($item);
        
        } catch (\Exception $e) {
            return response()->json([
                "message" => __("Une erreur inattendue a été rencontrée. Veuillez réessayer"),
            ], 500); // Internal Server Error
        }
    }
    
   /**
     * Update a resource.
     *
     * @return Response
     */
    public function update(LigneRequest $request, $uuid)
    {
        try {
            $item = $this->ligneRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Ligne non trouvée"),
            ];
            return reponse_json_transform($data);
        }        
        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;

        if(isset($attributs['budget_id'])) {
            $budget = $this->budgetRepositoryEloquent->findByUuid($attributs['budget_id'])->first();
            $attributs['budget_id'] = $budget->id;
        }

        $item = $this->ligneRepositoryEloquent->update($attributs, $item->id);
        $item = $item->fresh();
        return new LigneResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $item = $this->ligneRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Ligne non trouvée"),
            ];
            return reponse_json_transform($data);
        }
        //@TODO : Implémenter les conditions de suppression
        if(count($item->lignes) == 0){
            $this->ligneRepositoryEloquent->delete($item->id);
            
            $data = [
                "message" => __("Ligne supprimée avec succès"),
            ];
        } else {
            $data = [
                "message" => __("Ligne non supprimée car associée à des écritures"),
            ];
        }
        return reponse_json_transform($data);
    }    
}
