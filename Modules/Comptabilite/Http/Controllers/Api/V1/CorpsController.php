<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Comptabilite\Entities\Corps;
use App\Repositories\UserRepositoryEloquent;
use Modules\Comptabilite\Http\Requests\CorpsRequest;
use Modules\Comptabilite\Http\Resources\CorpsResource;
use Modules\Comptabilite\Http\Resources\CorpssResource;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;
use Modules\Comptabilite\Repositories\MorgueRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;

class CorpsController extends ComptabiliteController
{

    /**
     * @var PostRepository
     */
    protected $corpsRepositoryEloquent, $userRepositoryEloquent, $morgueRepositoryEloquent;

    public function __construct(CorpsRepositoryEloquent $corpsRepositoryEloquent, UserRepositoryEloquent $userRepositoryEloquent, MorgueRepositoryEloquent $morgueRepositoryEloquent)
    {
        parent::__construct();
        $this->corpsRepositoryEloquent = $corpsRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
        $this->morgueRepositoryEloquent = $morgueRepositoryEloquent;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = $this->corpsRepositoryEloquent->orderBy('id', 'DESC')->get();
        return new CorpssResource($items);
    }

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid)
    {
        try {
            $item = $this->corpsRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Corps non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new CorpsResource($item);
    }

    /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(CorpsRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;
                if (isset($attributs['morgue_id'])) {
                    $morgue = $this->morgueRepositoryEloquent->findByUuid($attributs['morgue_id'])->first();
                    $attributs['morgue_id'] = $morgue->id;
                }
                $item = $this->corpsRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Corps ajouté avec succès"),
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
    public function update(CorpsRequest $request, $uuid)
    {
        try {
            $item = $this->corpsRepositoryEloquent->findByUuidOrFail($uuid)->first(); //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Corps non trouvé"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;
        if (isset($attributs['morgue_id'])) {
            $morgue = $this->morgueRepositoryEloquent->findByUuid($attributs['morgue_id'])->first();
            $attributs['morgue_id'] = $morgue->id;
        }

        try {
            $item = $this->corpsRepositoryEloquent->update($attributs, $item->id);
            $item = $item->fresh();
            $data = [
                "message" => __("Corps modifié avec succès"),
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
            $total = Corps::count(); // Compter le nombre total de corps enregistrés dans la base de données

            return $total;
        } catch (\Exception $e) {
            // Gérer les erreurs si nécessaire
            return 0; // Ou une autre valeur par défaut
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */


    // public function destroy($uuid)
    // {
    //     try {
    //         $item = $this->corpsRepositoryEloquent->findByUuidOrFail($uuid)->first(); // Vérifier si l'élément existe
    //     } catch (\Throwable $th) {
    //         $data = [
    //             "message" => __("Corps non trouvé"),
    //             "resultat" => 0, // Utilisation de 0 au lieu de la fonction __() pour la clarté
    //         ];
    //         return reponse_json_transform($data);
    //     }

    //     // Implémenter des conditions de suppression si nécessaire
    //     try {
    //         $this->corpsRepositoryEloquent->delete($item->id); // Supprimer l'élément
    //         $data = [
    //             "message" => __("Corps supprimé avec succès"),
    //             "resultat" => 1,
    //         ];
    //     } catch (\Exception $e) {
    //         $data = [
    //             "message" => __("Une erreur s'est produite lors de la suppression du corps. Veuillez réessayer."),
    //             "resultat" => 0,
    //         ];
    //     }

    //     return reponse_json_transform($data);
    // }

    public function destroy($uuid)
    {
        try {
            $corps = $this->corpsRepositoryEloquent->findByUuidOrFail($uuid)->first(); // Vérifier si l'élément existe
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Corps non trouvé"),
                "resultat" => 0,
            ];
            return reponse_json_transform($data);
        }

        // Vérifier si le corps a au moins un examen médical, une autorisation ou un mouvement
        if ($corps->examens()->exists() || $corps->autorisations()->exists() || $corps->mouvements()->exists()) {
            $data = [
                "message" => __("Impossible de supprimer ce corps car il a des enfants."),
                "resultat" => 0,
            ];
            return reponse_json_transform($data);
        }

        // Supprimer le corps s'il n'a pas d'enfants
        try {
            $this->corpsRepositoryEloquent->delete($corps->id);
            $data = [
                "message" => __("Corps supprimé avec succès"),
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
