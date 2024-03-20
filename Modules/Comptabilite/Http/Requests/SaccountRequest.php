<?php

namespace Modules\Comptabilite\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class SaccountRequest extends BaseRequest {

    protected $entite = "Saccount"; //Nom de l'objet, pour les percomptes par exemple
    protected $nom_param_route = "saccount"; //request route parameter
    protected $nom_table_suffixe = "saccounts"; //le nom de la table sans prefixe
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
            // 'num' => [
            //     'bail',
            //     'required',
            //     'integer',
            //     'max:255',
            //     Rule::unique('saccounts', 'num')->ignore(SaccountRequest::all()['num'], 'num'),
            // ],
            'libelle' => [
                'bail',
                'required',
                'string',
                'max:255',
                Rule::unique('saccounts', 'libelle')->ignore(SaccountRequest::all()['libelle'], 'libelle'),
            ],
            'parent_id' => [
                'bail',
                'required',
                'exists:saccounts,uuid',
            ],
            'saccount_class_id' => [
                'bail',
                'required',
                'exists:saccount_classes,uuid',
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
