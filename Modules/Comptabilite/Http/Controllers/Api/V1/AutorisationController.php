<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Comptabilite\Http\Requests\AutorisationRequest;
use Modules\Comptabilite\Http\Resources\AutorisationResource;
use Modules\Comptabilite\Http\Resources\AutorisationsResource;

use Modules\Document\Repositories\DocumentRepositoryEloquent;
use Modules\Comptabilite\Repositories\MouvementRepositoryEloquent;
use Modules\Comptabilite\Repositories\ExamenRepositoryEloquent;
use Modules\Comptabilite\Repositories\SaccountRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Entities\Autorisation;
use Modules\Comptabilite\Repositories\AutorisationRepositoryEloquent;
use Modules\Comptabilite\Repositories\LigneRepositoryEloquent;

class AutorisationController extends ComptabiliteController {

    /**
     * @var 
     */
    protected $autorisationRepositoryEloquent, $userRepositoryEloquent, $documentRepositoryEloquent, $corpsRepositoryEloquent, $mouvementRepositoryEloquent, $saccountRepositoryEloquent, $transactionRepositoryEloquent, $examenRepositoryEloquent, $ligneRepositoryEloquent;

    public function __construct(AutorisationRepositoryEloquent $autorisationRepositoryEloquent, CorpsRepositoryEloquent $corpsRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->autorisationRepositoryEloquent = $autorisationRepositoryEloquent;
        $this->corpsRepositoryEloquent = $corpsRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $donnees = $this->autorisationRepositoryEloquent->orderBy('id', 'DESC')->get();
        return new AutorisationsResource($donnees);
    }
    
    /**
     * Display a listing of the resource by JOURNAL.
     *
     * @return Response
     */
    // public function journal_index($journal)
    // {
    //     $journal = $this->examenRepositoryEloquent->findByUuid($journal)->first();
    //     $donnees = $this->ecritureRepositoryEloquent->where([['journal_id', $journal->id], ['exercice_id', parametre_api()->exercice_id]])->orderBy('id', 'DESC')->get();
    //     return new EcrituresResource($donnees);
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->autorisationRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Ecriture non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new AutorisationResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(AutorisationRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs, $request) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;
                if (isset($attributs['corps_id'])) {
                    $corps = $this->corpsRepositoryEloquent->findByUuid($attributs['corps_id'])->first();
                    $attributs['corps_id'] = $corps->id;
                }

                
                // \Log::info($attributs);
                $item = $this->autorisationRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Autorisation ajoutée avec succès"),
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

    public function total()
    {
        try {
            $total = Autorisation::count(); // Compter le nombre total de corps enregistrés dans la base de données
    
            return $total;
        } catch (\Exception $e) {
            // Gérer les erreurs si nécessaire
            return 0; // Ou une autre valeur par défaut
        }
    }
    
   /**
     * Update a resource.
     *
     * @return Response
     */
    public function update(AutorisationRequest $request, $uuid)
    {
        try {
            $item = $this->autorisationRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Autorisation non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }        
        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;
        if (isset($attributs['corps_id'])) {
            $corps = $this->corpsRepositoryEloquent->findByUuid($attributs['corps_id'])->first();
            $attributs['corps_id'] = $corps->id;
        }

        try {
         
            $item = $this->autorisationRepositoryEloquent->update($attributs, $item->id);                
            $item = $item->fresh();
            $data = [
                "message" => __("Autorisation modifiée avec succès"),
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
            $ecriture = $this->autorisationRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Autorisation non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $this->autorisationRepositoryEloquent->delete($ecriture->id);             
        $data = [
            "message" => __("Autorisation supprimée avec succès"),
            "resultat" => __(1),
        ];

        return reponse_json_transform($data);
    }    
}
