<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Entities\Examen;
use Modules\Comptabilite\Http\Requests\ExamenRequest;
use Modules\Comptabilite\Http\Resources\ExamenResource;
use Modules\Comptabilite\Http\Resources\ExamensResource;
use Modules\Comptabilite\Repositories\ExamenRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;

class ExamenController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $examenRepositoryEloquent, $corpsRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(ExamenRepositoryEloquent $examenRepositoryEloquent, CorpsRepositoryEloquent $corpsRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->examenRepositoryEloquent = $examenRepositoryEloquent;
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
        $donnees = $this->examenRepositoryEloquent->orderBy('id', 'DESC')->get();
        return new ExamensResource($donnees);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->examenRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Examen non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new ExamenResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(ExamenRequest $request)
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


                $item = $this->examenRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Examen ajouté avec succès"),
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
            $total = Examen::count(); // Compter le nombre total de corps enregistrés dans la base de données
    
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
    public function update(ExamenRequest $request, $uuid)
    {
        try {
            $item = $this->examenRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Examen non trouvé"),
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
            $item = $this->examenRepositoryEloquent->update($attributs, $item->id);
            $item = $item->fresh();
            $data = [
                "message" => __("Examen modifié avec succès"),
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
            $item = $this->examenRepositoryEloquent->findByUuidOrFail($uuid)->first(); // Vérifier si l'élément existe
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Examen non trouvé"),
                "resultat" => 0, // Utilisation de 0 au lieu de la fonction __() pour la clarté
            ];
            return reponse_json_transform($data);
        }

        // Implémenter des conditions de suppression si nécessaire
        try {
            $this->examenRepositoryEloquent->delete($item->id); // Supprimer l'élément
            $data = [
                "message" => __("Examen supprimé avec succès"),
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
