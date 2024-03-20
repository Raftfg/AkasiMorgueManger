<?php

namespace Modules\Comptabilite\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class MouvementRequest extends BaseRequest
{

    protected $entite = "Mouvement_corps"; //Nom de l'objet, pour les perdevises par exemple
    protected $nom_param_route = "mouvement_corps"; //request route parameter
    protected $nom_table_suffixe = "mouvement_corpss"; //le nom de la table sans prefixe
    protected $prefixe_table = null;   //prefixe des tables du module
    protected $nom_table = null; //le nom de la table sans prefixe
    public function __construct()
    {
        parent::__construct();
        $this->nom_table = $this->prefixe_table . $this->nom_table_suffixe;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function reglesCommunes()
    {
        $rules = [
            'Lieu_Départ' => ['required', 'string', 'max:255'],
            'lieu_arrivee' => ['required', 'string', 'max:255'],
            'date_heure_depart' => ['required', 'date_format:Y-m-d\TH:i'],
            'date_heure_arrivee' => ['required', 'date_format:Y-m-d\TH:i'],
            'responsable_mouvement' => ['required', 'string', 'max:255'],
            'corps_id' => ['required', 'exists:corps,uuid'],
        ];

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return user_api()->isPermission("update $this->entite");
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uuid = request()->route($this->nom_param_route);
        $rules = $this->reglesCommunes();
        return $rules;
    }
}
