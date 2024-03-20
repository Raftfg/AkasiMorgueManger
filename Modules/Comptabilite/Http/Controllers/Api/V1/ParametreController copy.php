<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Requests\ParametreRequest;
use Modules\Comptabilite\Http\Resources\ParametreResource;
use Modules\Comptabilite\Http\Resources\ParametresResource;
use Modules\Comptabilite\Repositories\DeviseRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;
use Modules\Comptabilite\Repositories\ParametreRepositoryEloquent;

class ParametreController extends ComptabiliteController {

    /**
     * @var PostRepository
     */
    protected $parametreRepositoryEloquent, $corpsRepositoryEloquent, $deviseRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(ParametreRepositoryEloquent $parametreRepositoryEloquent, CorpsRepositoryEloquent $corpsRepositoryEloquent, DeviseRepositoryEloquent $deviseRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent) 
    {
        parent::__construct();
        $this->parametreRepositoryEloquent = $parametreRepositoryEloquent;
        $this->deviseRepositoryEloquent = $deviseRepositoryEloquent;
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
        $items = $this->parametreRepositoryEloquent->orderBy('id', 'DESC')->paginate($this->nombrePage);
        return new ParametresResource($items);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show() 
    {
        try {
            $item = $this->parametreRepositoryEloquent->find(1); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Paramètre non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new ParametreResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(ParametreRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;                

                if(isset($attributs['exercice_id'])) {
                    $exercice = $this->corpsRepositoryEloquent->findByUuid($attributs['exercice_id'])->first();
                    $attributs['exercice_id'] = $exercice->id;
                }
                
                if (isset($attributs['devise_id'])) {
                    $devise = $this->deviseRepositoryEloquent->findByUuid($attributs['devise_id'])->first();
                    $attributs['devise_id'] = $devise->id;
                }

                $item = $this->parametreRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Paramètre ajouté avec succès"),
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
    public function update(ParametreRequest $request, $uuid)
    {
        try {
            $item = $this->parametreRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Paramètre non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;

        if(isset($attributs['exercice_id'])) {
            $exercice = $this->corpsRepositoryEloquent->findByUuid($attributs['exercice_id'])->first();
            $attributs['exercice_id'] = $exercice->id;
        }
        
        if (isset($attributs['devise_id'])) {
            $devise = $this->deviseRepositoryEloquent->findByUuid($attributs['devise_id'])->first();
            $attributs['devise_id'] = $devise->id;
        }

        try {
            $item = $this->parametreRepositoryEloquent->update($attributs, $item->id);
            $item = $item->fresh();
            $data = [
                "message" => __("Paramètre modifié avec succès"),
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
        $data = [
            "message" => __("Impossible de supprimer les paramètres de l'application"),
            "resultat" => __(0),
        ];
        return reponse_json_transform($data);
    }    
}
