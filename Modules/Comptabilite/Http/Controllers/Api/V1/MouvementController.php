<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Entities\Mouvement;
use Modules\Comptabilite\Http\Requests\MouvementRequest;
use Modules\Comptabilite\Http\Resources\MouvementResource;
use Modules\Comptabilite\Http\Resources\MouvementsResource;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\MouvementRepositoryEloquent;

class MouvementController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $mouvementRepositoryEloquent,$corpsRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(MouvementRepositoryEloquent $mouvementRepositoryEloquent, CorpsRepositoryEloquent $corpsRepositoryEloquent,  UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->mouvementRepositoryEloquent = $mouvementRepositoryEloquent;
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

        $items = $this->mouvementRepositoryEloquent->orderBy('id', 'DESC')->get();
        // dd($items);
        return new MouvementsResource($items);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->mouvementRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Mouvement de corps non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new MouvementResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(MouvementRequest $request)
    { 
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;
                if (isset($attributs['corps_id'])) {
                    $corps = $this->corpsRepositoryEloquent->findByUuid($attributs['corps_id'])->first();
                    $attributs['corps_id'] = $corps->id;
                }
                $item = $this->mouvementRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Mouvement corps ajouté avec succès"),
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
            $total = Mouvement::count(); // Compter le nombre total de corps enregistrés dans la base de données
    
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
    public function update(MouvementRequest $request, $uuid)
    {
        // \Log::error($request);
        try {
            $item = $this->mouvementRepositoryEloquent->findByUuidOrFail($uuid)->first();
            // \Log::info($item); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Mouvement de corps non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;
         // $attributs['user_id'] = 4;
         if (isset($attributs['corps_id'])) {
            $corps = $this->corpsRepositoryEloquent->findByUuid($attributs['corps_id'])->first();
            $attributs['corps_id'] = $corps->id;
        }

        try {
            $item = $this->mouvementRepositoryEloquent->update($attributs, $item->id);
            // \Log::info($item);
            $item = $item->fresh();
            $data = [
                "message" => __("Mouvement de corps modifié avec succès"),
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
            $item = $this->mouvementRepositoryEloquent->findByUuidOrFail($uuid)->first(); // Vérifier si l'élément existe
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Mouvement de corps non trouvé"),
                "resultat" => 0, // Utilisation de 0 au lieu de la fonction __() pour la clarté
            ];
            return reponse_json_transform($data);
        }

        // Implémenter des conditions de suppression si nécessaire
        try {
            $this->mouvementRepositoryEloquent->delete($item->id); // Supprimer l'élément
            $data = [
                "message" => __("Mouvement de corps supprimé avec succès"),
                "resultat" => 1,
            ];
        } catch (\Exception $e) {
            $data = [
                "message" => __("Une erreur s'est produite lors de la suppression du corps. Veuillez réessayer."),
                "resultat" => 0,
            ];
        }

        return reponse_json_transform($data);
    }    
}
