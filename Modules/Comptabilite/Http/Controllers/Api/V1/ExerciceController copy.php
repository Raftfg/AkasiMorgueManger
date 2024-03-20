<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Resources\ExerciceResource;
use Modules\Comptabilite\Http\Resources\ExercicesResource;
use Modules\Comptabilite\Http\Requests\ExerciceRequest;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\ExerciceRepositoryEloquent;

class ExerciceController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $exerciceRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(ExerciceRepositoryEloquent $exerciceRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->exerciceRepositoryEloquent = $exerciceRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = $this->exerciceRepositoryEloquent->orderBy('id', 'DESC')->get();
        return new ExercicesResource($items);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->exerciceRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Exercice non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new ExerciceResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(ExerciceRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;
                $item = $this->exerciceRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Exercice ajouté avec succès"),
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
    public function update(ExerciceRequest $request, $uuid)
    {
        try {
            $item = $this->exerciceRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Exercice non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;

        try {
            $item = $this->exerciceRepositoryEloquent->update($attributs, $item->id);
            $item = $item->fresh();
            $data = [
                "message" => __("Exercice modifié avec succès"),
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
            $item = $this->exerciceRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Exercice non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        //@TODO : Implémenter les conditions de suppression
        if(count($item->ecritures) != 0){
            $data = [
                "message" => __("Exercice non supprimé car contenant des écritures"),
                "resultat" => __(0),
            ];
        }
        else if(isset($item->budget)){
            $data = [
                "message" => __("Exercice non supprimé car associé à un budget"),
                "resultat" => __(0),
            ];
        }
        else if(isset($item->parametre)){
            $data = [
                "message" => __("Exercice non supprimé car utilisé dans les paramètres"),
                "resultat" => __(0),
            ];
        }
        else {
            $this->exerciceRepositoryEloquent->delete($item->id);            
            $data = [
                "message" => __("Exercice supprimé avec succès"),
                "resultat" => __(1),
            ];
        }
        
        return reponse_json_transform($data);
    }    
}
