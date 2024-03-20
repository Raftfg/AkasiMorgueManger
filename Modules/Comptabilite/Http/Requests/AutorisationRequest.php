<?php

namespace Modules\Comptabilite\Http\Requests;

use App\Http\Requests\BaseRequest;

class AutorisationRequest extends BaseRequest
{

    protected $entite = "Autorisation"; //Nom de l'objet, pour les permissions par exemple
    protected $nom_param_route = "autorisation"; //request route parameter
    protected $nom_table_suffixe = "autorisations"; //le nom de la table sans prefixe
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
            'corps_id' => [
                'required',
                 'exists:corps,uuid'
                ],
            'date_autorisation' => [
                'required',
                'date', // ou toute autre validation spécifique à la date
            ],
            'Nom_autorisant' => [
                'required',
                'string',
                'max:255',
            ],
            'type_autorisation' => [
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
