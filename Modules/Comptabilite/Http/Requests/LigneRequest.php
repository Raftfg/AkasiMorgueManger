<?php

namespace Modules\Comptabilite\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class LigneRequest extends BaseRequest {

    protected $entite = "Ligne"; //Nom de l'objet, pour les percomptes par exemple
    protected $nom_param_route = "ligne"; //request route parameter
    protected $nom_table_suffixe = "lignes"; //le nom de la table sans prefixe
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
                // 'unique:lignes,libelle,NULL,id',
                // Rule::unique('lignes', 'libelle')->ignore(LigneRequest::all()['libelle'], 'libelle'),
                Rule::unique('lignes')->where(function ($query) {
                    return $query->where([['libelle', LigneRequest::all()['libelle']], ['budget_id', LigneRequest::all()['budget_id']]]);
                })->ignore(LigneRequest::input()['libelle'], 'libelle'),
            ],
            'description' => [
                'bail',
                'string',
                'max:255',
            ],
            'budget_id' => [
                'bail',
                'required',
                'uuid',
                'exists:budgets,uuid',
            ],
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
