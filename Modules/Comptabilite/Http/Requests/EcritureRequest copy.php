<?php

namespace Modules\Comptabilite\Http\Requests;

use App\Http\Requests\BaseRequest;

class EcritureRequest extends BaseRequest {

    protected $entite = "Ecriture"; //Nom de l'objet, pour les permissions par exemple
    protected $nom_param_route = "ecriture"; //request route parameter
    protected $nom_table_suffixe = "ecritures"; //le nom de la table sans prefixe
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
                // 'unique:ecritures,libelle,NULL,id',
            ],
            'montant' => [
                'bail',
                'required',
                'decimal:0,2',
            ],
            'taxe' => [
                'bail',
                'nullable',
                'decimal:0,2',
            ],
            // 'description' => [
            //     'bail',
            //     'string',
            //     'max:255',
            // ],
            'date' => [
                'bail',
                'required',
                'date',
            ],
            'exercice_id' => [
                'bail',
                'required',
                'exists:exercices,uuid',
            ],
            'devise_id' => [
                'bail',
                'required',
                'exists:devises,uuid',
            ],
            'journal_id' => [
                'bail',
                'required',
                'exists:journaux,uuid',
            ],
            'ligne_id' => [
                'bail',
                'nullable',
                'exists:lignes,uuid',
            ],
            'compte_debit_id' => [
                'bail',
                'nullable',
                'exists:saccounts,uuid',
                'required_if:compte_credit_id,null',
            ],
            'compte_credit_id' => [
                'bail',
                'nullable',
                'exists:saccounts,uuid',
                'different:compte_debit_id',
                'required_if:compte_debit_id,null',
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
