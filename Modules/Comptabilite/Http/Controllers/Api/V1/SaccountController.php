<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Requests\SaccountRequest;
use Modules\Comptabilite\Http\Resources\SaccountResource;
use Modules\Comptabilite\Http\Resources\SaccountsResource;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\SaccountRepositoryEloquent;
use Modules\Comptabilite\Repositories\MorgueRepositoryEloquent;

class SaccountController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $saccountRepositoryEloquent, $morgueRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(SaccountRepositoryEloquent $saccountRepositoryEloquent, MorgueRepositoryEloquent $morgueRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) {
        parent::__construct();
        $this->saccountRepositoryEloquent = $saccountRepositoryEloquent;
        $this->morgueRepositoryEloquent = $morgueRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $donnees = $this->saccountRepositoryEloquent->orderBy('id', 'ASC')->paginate(50);
        $donnees = $this->saccountRepositoryEloquent
            ->orderBy('num_float', 'ASC')
            ->select(['*', DB::raw('CAST(CONCAT("0.", num) AS DECIMAL(10, 8)) AS num_float')])
            ->get();
        return new SaccountsResource($donnees);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid)
    {
        try {
            $item = $this->saccountRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Compte non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new SaccountResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(SaccountRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;

                if(isset($attributs['parent_id'])) {
                    $parent = $this->saccountRepositoryEloquent->findByUuid($attributs['parent_id'])->first();
                    $attributs['parent_id'] = $parent->num;
                }

                if(isset($attributs['saccount_class_id'])) {
                    $saccount_class = $this->morgueRepositoryEloquent->findByUuid($attributs['saccount_class_id'])->first();
                    $attributs['saccount_class_id'] = $saccount_class->id;
                }

                $item = $this->saccountRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Compte ajouté avec succès"),
                "resultat" => __(1),
            ]; 
        
        } catch (\Exception $e) {
            $data = [
                "message" => __("Une erreur inattendue a été rencontrée. Veuillez réessayer"),
                "resultat" => __(0),
            ]; // Internal Server Error
        }
            
        return reponse_json_transform($data);
    }
    
   /**
     * Update a resource.
     *
     * @return Response
     */
    public function update(SaccountRequest $request, $uuid)
    {
        $item = $this->saccountRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        $attributs = $request->all();

        // $user = $this->userRepositoryEloquent->findByUuid($attributs['user_id'])->first();
        $attributs['user_id'] = user_api()->id;

        $item = $this->saccountRepositoryEloquent->update($attributs, $item->id);
        $item = $item->fresh();
        return new SaccountResource($item);
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
            $item = $this->saccountRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Compte non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        //@TODO : Implémenter les conditions de suppression
        if(count($item->ecritures_debit) != 0 || count($item->ecritures_credit) != 0){
            $data = [
                "message" => __("Compte non supprimé car associé à des écritures comptables"),
                "resultat" => __(0),
            ];
        } 
        else if(count($item->journaux_debit) != 0 || count($item->journaux_credit) != 0){
            $data = [
                "message" => __("Compte non supprimé car associé à des journaux"),
                "resultat" => __(0),
            ];
        } 
        else if($item->user_id == 1){
            $data = [
                "message" => __("Compte non supprimé car étant un compte système"),
                "resultat" => __(0),
            ];
        }
        else {
            $this->saccountRepositoryEloquent->delete($item->id);            
            $data = [
                "message" => __("Compte supprimé avec succès"),
                "resultat" => __(1),
            ];
        }

        return reponse_json_transform($data);
    }    
}
