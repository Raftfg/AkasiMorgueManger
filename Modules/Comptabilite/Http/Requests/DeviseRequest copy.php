<?php

namespace Modules\Comptabilite\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class DeviseRequest extends BaseRequest {

    protected $entite = "Devise"; //Nom de l'objet, pour les perdevises par exemple
    protected $nom_param_route = "devise"; //request route parameter
    protected $nom_table_suffixe = "devises"; //le nom de la table sans prefixe
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
            // 'code' => [
            //     'bail',
            //     'nullable',
            //     'string',
            //     'max:255',
            //     Rule::unique('devises', 'code')->ignore(DeviseRequest::input('code'), 'code'),
            // ],
            'libelle' => [
                'bail',
                'required',
                'string',
                'max:255',
                // 'unique:devises,libelle,NULL,id',
                Rule::unique('devises', 'libelle')->ignore(DeviseRequest::input()['libelle'], 'libelle'),
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
