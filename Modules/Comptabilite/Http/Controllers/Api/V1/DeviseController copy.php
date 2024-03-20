<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Resources\DeviseResource;
use Modules\Comptabilite\Http\Resources\DevisesResource;
use Modules\Comptabilite\Http\Requests\DeviseRequest;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\DeviseRepositoryEloquent;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;

class DeviseController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $deviseRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(DeviseRepositoryEloquent $deviseRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->deviseRepositoryEloquent = $deviseRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = $this->deviseRepositoryEloquent->orderBy('id', 'DESC')->get();
        return new DevisesResource($items);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->deviseRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Devise non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new DeviseResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(DeviseRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;
                $item = $this->deviseRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Devise ajoutée avec succès"),
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
    public function update(DeviseRequest $request, $uuid)
    {
        \Log::error($request);
        try {
            $item = $this->deviseRepositoryEloquent->findByUuidOrFail($uuid)->first();
            \Log::info($item); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Devise non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;

        try {
            $item = $this->deviseRepositoryEloquent->update($attributs, $item->id);
            \Log::info($item);
            $item = $item->fresh();
            $data = [
                "message" => __("Devise modifiée avec succès"),
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
            $item = $this->deviseRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Devise non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        //@TODO : Implémenter les conditions de suppression
        if(count($item->ecritures) != 0){
            $data = [
                "message" => __("Devise non supprimée car contenant des écritures"),
                "resultat" => __(0),
            ];
        }
        else if(isset($item->parametre)){
            $data = [
                "message" => __("Devise non supprimée car utilisée dans les paramètres"),
                "resultat" => __(0),
            ];
        }
        else {
            $this->deviseRepositoryEloquent->delete($item->id);            
            $data = [
                "message" => __("Devise supprimée avec succès"),
                "resultat" => __(1),
            ];
        }
        
        return reponse_json_transform($data);
    }    
}
