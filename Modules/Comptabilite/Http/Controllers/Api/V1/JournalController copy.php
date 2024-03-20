<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Requests\JournalRequest;
use Modules\Comptabilite\Http\Resources\JournalResource;
use Modules\Comptabilite\Http\Resources\JournauxResource;
use Modules\Comptabilite\Repositories\JournalRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\SaccountRepositoryEloquent;

class JournalController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $journalRepositoryEloquent, $saccountRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(JournalRepositoryEloquent $journalRepositoryEloquent, SaccountRepositoryEloquent $saccountRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->journalRepositoryEloquent = $journalRepositoryEloquent;
        $this->saccountRepositoryEloquent = $saccountRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $donnees = $this->journalRepositoryEloquent->orderBy('id', 'DESC')->get();
        return new JournauxResource($donnees);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->journalRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Journal non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new JournalResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(JournalRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;

                if(isset($attributs['compte_debit_id'])) {
                    $compte_debit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_debit_id'])->first();
                    $attributs['compte_debit_id'] = $compte_debit->id;
                }

                if(isset($attributs['compte_credit_id'])) {
                    $compte_credit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_credit_id'])->first();
                    $attributs['compte_credit_id'] = $compte_credit->id;
                }

                $item = $this->journalRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Journal ajouté avec succès"),
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
    public function update(JournalRequest $request, $uuid)
    {
        try {
            $item = $this->journalRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Journal non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }        
        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;

        if(isset($attributs['compte_debit_id'])) {
            $compte_debit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_debit_id'])->first();
            $attributs['compte_debit_id'] = $compte_debit->id;
        }

        if(isset($attributs['compte_credit_id'])) {
            $compte_credit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_credit_id'])->first();
            $attributs['compte_credit_id'] = $compte_credit->id;
        }

        try {
            $item = $this->journalRepositoryEloquent->update($attributs, $item->id);
            $item = $item->fresh();
            $data = [
                "message" => __("Journal modifié avec succès"),
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
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $item = $this->journalRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Journal non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        //@TODO : Implémenter les conditions de suppression
        if(count($item->ecritures) != 0){
            $data = [
                "message" => __("Journal non supprimé car contenant des écritures"),
                "resultat" => __(0),
            ];
        } else {
            $this->journalRepositoryEloquent->delete($item->id);
            $data = [
                "message" => __("Journal supprimé avec succès"),
                "resultat" => __(1),
            ];
        }
            
        return reponse_json_transform($data);
    }    
}
