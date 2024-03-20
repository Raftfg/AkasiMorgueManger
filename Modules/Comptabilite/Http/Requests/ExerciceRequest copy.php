<?php

namespace Modules\Comptabilite\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ExerciceRequest extends BaseRequest {

    protected $entite = "Exercice"; //Nom de l'objet, pour les permissions par exemple
    protected $nom_param_route = "exercice"; //request route parameter
    protected $nom_table_suffixe = "exercices"; //le nom de la table sans prefixe
    protected $prefixe_table = null;   //prefixe des tables du module
    protected $nom_table = null; //le nom de la table sans prefixe
    public function __construct() {
        parent::__construct();
        $this->nom_table = $this->prefixe_table.$this->nom_table_suffixe;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function reglesCommunes() {
        $rules = [
            'libelle' => [
                'bail',
                'required',
                'string',
                'max:255',
                // 'unique:exercices,libelle,NULL,id',
                Rule::unique('exercices', 'libelle')->ignore(ExerciceRequest::all()['libelle'], 'libelle'),
            ],
            'description' => [
                'bail',
                'string',
                'max:255',
            ],
            'statut' => [
                'nullable',
                'boolean',
            ],
            'date_debut' => [
                'bail',
                'required',
                'date',
            ],
            'date_fin' => [
                'bail',
                'required',
                'date',
            ]
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
