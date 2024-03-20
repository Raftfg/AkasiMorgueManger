<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Resources\BudgetResource;
use Modules\Comptabilite\Http\Resources\BudgetsResource;
use Modules\Comptabilite\Http\Requests\BudgetRequest;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\BudgetRepositoryEloquent;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;

class BudgetController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $budgetRepositoryEloquent, $corpsRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(BudgetRepositoryEloquent $budgetRepositoryEloquent,CorpsRepositoryEloquent $corpsRepositoryEloquent , UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->userRepositoryEloquent = $userRepositoryEloquent;
        $this->budgetRepositoryEloquent = $budgetRepositoryEloquent;
        $this->corpsRepositoryEloquent = $corpsRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $donnees = $this->budgetRepositoryEloquent->get();
        return new BudgetsResource($donnees);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->budgetRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Budget non trouvé"),
            ];
            return reponse_json_transform($data);
        }
        return new BudgetResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(BudgetRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;

                if(isset($attributs['exercice_id'])) {
                    $exercice = $this->corpsRepositoryEloquent->findByUuid($attributs['exercice_id'])->first();
                    $attributs['exercice_id'] = $exercice->id;
                }

                $item = $this->budgetRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            return new BudgetResource($item);
        
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
    public function update(BudgetRequest $request, $uuid)
    {
        try {
            $item = $this->budgetRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Budget non trouvé"),
            ];
            return reponse_json_transform($data);
        }        
        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;

        if(isset($attributs['exercice_id'])) {
            $exercice = $this->corpsRepositoryEloquent->findByUuid($attributs['exercice_id'])->first();
            $attributs['exercice_id'] = $exercice->id;
        }

        $item = $this->budgetRepositoryEloquent->update($attributs, $item->id);
        $item = $item->fresh();
        return new BudgetResource($item);
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
            $item = $this->budgetRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Budget non trouvé"),
            ];
            return reponse_json_transform($data);
        }
        //@TODO : Implémenter les conditions de suppression
        if(count($item->lignes) == 0){
            $this->budgetRepositoryEloquent->delete($item->id);
            
            $data = [
                "message" => __("Budget supprimé avec succès"),
            ];
        } else {
            $data = [
                "message" => __("Budget non supprimé car contenant des lignes"),
            ];
        }
        return reponse_json_transform($data);
    }    
}
