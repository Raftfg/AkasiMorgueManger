<?php

namespace Modules\Comptabilite\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class BudgetRequest extends BaseRequest {

    protected $entite = "Budget"; //Nom de l'objet, pour les percomptes par exemple
    protected $nom_param_route = "budget"; //request route parameter
    protected $nom_table_suffixe = "budgets"; //le nom de la table sans prefixe
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
            'code' => [
                'bail',
                'nullable',
                'string',
                'max:255',
            ],
            'libelle' => [
                'bail',
                'required',
                'string',
                'max:255',
                // 'unique:budgets,libelle,NULL,id',
                Rule::unique('budgets', 'libelle')->ignore(BudgetRequest::all()['code'], 'code'),
            ],
            'description' => [
                'bail',
                'string',
                'max:255',
            ],
            'exercice_id' => [
                'bail',
                'required',
                'uuid',
                'exists:exercices,uuid',
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
