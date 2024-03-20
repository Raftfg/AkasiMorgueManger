<?php

namespace Modules\Comptabilite\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CorpsRequest extends BaseRequest {

    protected $entite = "Corps"; //Nom de l'objet, pour les permissions par exemple
    protected $nom_param_route = "corps"; //request route parameter
    protected $nom_table_suffixe = "corpss"; //le nom de la table sans prefixe
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
            'nom_defunt' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
            'prenom_defunt' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
            'date_naissance' => [
                'bail',
                'required',
                'date',
            ],
            'date_deces' => [
                'bail',
                'required',
                'date',
            ],
            'lieu_deces' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
            'cause_décès' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
            'morgue_id' => [
                'bail',
                'required',
                'exists:morgues,uuid',
            ],
            'etat_corps' => [
                'bail',
                'required',
                'string',
                'max:255',
                
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
