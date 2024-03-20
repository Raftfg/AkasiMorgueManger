<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Comptabilite\Entities\Morgue;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Requests\MorgueRequest;
use Modules\Comptabilite\Http\Resources\MorgueResource;
use Modules\Comptabilite\Http\Resources\MorguesResource;
use Modules\Comptabilite\Http\Requests\SaccountClassRequest;
use Modules\Comptabilite\Http\Resources\SaccountClassResource;
use Modules\Comptabilite\Repositories\MorgueRepositoryEloquent;
use Modules\Comptabilite\Http\Resources\SaccountClassesResource;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\SaccountClassRepositoryEloquent;

class MorgueController extends ComptabiliteController
{

    /**
     * @var PostRepository
     */
    protected $morgueRepositoryEloquent, $userRepositoryEloquent;

    public function __construct(MorgueRepositoryEloquent $morgueRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent)
    {
        parent::__construct();
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
        $donnees = $this->morgueRepositoryEloquent->orderBy('id', 'desc')->get();
        return new MorguesResource($donnees);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid)
    {
        $item = $this->morgueRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        return new MorgueResource($item);
    }

    /**
     * Create a resource.
     *
     * @return Response
     */
    // public function store(MorgueRequest $request)
    // {
    //     $attributs = $request->all();

    //     $item = DB::transaction(function () use ($attributs) {
    //         // $user = $this->userRepositoryEloquent->findByUuid($attributs['user_id'])->first();
    //         $attributs['user_id'] = user_api()->id;

    //         $item = $this->morgueRepositoryEloquent->create($attributs);

    //         return $item;
    //     });

    //     $item = $item->fresh();

    //     return new MorgueResource($item);
    // }
    public function store(MorgueRequest $request)
    {
        $attributs = $request->all();

        $item = DB::transaction(function () use ($attributs) {
            $item = $this->morgueRepositoryEloquent->create($attributs);
            return $item;
        });

        $item = $item->fresh();
        // Créez votre tableau de réponse avec la clé 'original'
        $response = [
            'original' => [
                'data' => [
                    'resultat' => 1, // Par exemple, le résultat de l'opération
                    'message' => 'La morgue a été créée avec succès', // Par exemple, un message de succès
                    // Vous pouvez ajouter d'autres données si nécessaire
                ]
            ]
        ];

        return new MorgueResource($response);
    }


    /**
     * Update a resource.
     *
     * @return Response
     */
    // public function update(MorgueRequest $request, $uuid)
    // {

    //     $item = $this->morgueRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
    //     log::info($item);
    //     $attributs = $request->all();

    //     $item = $this->morgueRepositoryEloquent->update($attributs, $item->id);
    //     $item = $item->fresh();
    //     return new MorgueResource($item);
    // }
    public function update(MorgueRequest $request, $uuid)
    {
        Log::error($request);
        try {
            $item = $this->morgueRepositoryEloquent->findByUuidOrFail($uuid)->first();
            Log::info($item); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Morgue non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $attributs = $request->all();

        try {
            $item = $this->morgueRepositoryEloquent->update($attributs, $item->id);
            Log::info($item);
            $item = $item->fresh();
            $data = [
                "message" => __("Morgue modifiée avec succès"),
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
    // public function destroy($uuid)
    // {

    //     $data = [
    //         "message" => __("Le nom de la morgue supprimé avec succès"),
    //         "resultat" => __(0),
    //     ];

    //     log::info($data);
    //     return reponse_json_transform($data);
    // }    

    public function destroy($uuid)
    {
        // Supprimer la morgue
        $morgue = Morgue::where('uuid', $uuid)->first();
        if (!$morgue) {
            $data = [
                "message" => __("Morgue introuvable"),
                "resultat" => 0,
            ];
            return reponse_json_transform($data);
        }

        $morgue->delete();

        $data = [
            "message" => __("Le nom de la morgue supprimé avec succès"),
            "resultat" => 1, // Changer la valeur de resultat à 1 pour indiquer une suppression réussie
        ];

        Log::info($data); // Enregistrez les données dans les journaux

        return reponse_json_transform($data);
    }
}
