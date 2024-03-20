<?php

use App\Models\Ecole;
use Illuminate\Support\Facades\DB;
use Modules\Comptabilite\Entities\Ecriture;
use Modules\Comptabilite\Entities\Parametre;

/**
 * Guard par défaut du web
 *
 * @return string
 */
if (!function_exists('guard_web')) {

    function guard_web() {
        return config('auth.defaults.guard');
    }

}/**
 * Logged user
 *
 * @return mixed
 */
if (!function_exists('auth_user')) {

    function auth_user() {
        return \Auth::user();
    }
}

/**
 * Random password temp for SMS
 * 
 * @param int $long
 * 
 * @return string $string
 */
if (!function_exists('rand_password_temp')) {

    function rand_password_temp($long) {
        return rand_majuscule_nombre($long);
    }

}

/**
 * Random password temp for SMS
 * 
 * @param int $long
 * 
 * @return string $string
 */
if (!function_exists('rand_majuscule_nombre')) {

    function rand_majuscule_nombre($long) {
        $characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
        $string = '';
        for ($i = 0; $i < $long; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

}

/**
 * Random minuscule nombre
 * 
 * @param int $long
 * 
 * @return string $string
 */
if (!function_exists('rand_minuscule_nombre')) {

    function rand_minuscule_nombre($long) {
        $characters = 'abcdefghijklmnpqrstuvwxyz123456789';
        $string = '';
        for ($i = 0; $i < $long; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

}

/**
 * Décode json string sous forme de array
 * 
 * @param string $valeur
 * 
 * @return Ecole
 */
if (!function_exists('decode_json_array')) {

    function decode_json_array($valeur) {
        return json_decode($valeur, true);
    }

}


/**
 * Donne la langue courante
 * 
 * @return string
 */
if (!function_exists('langue')) {

    function langue() {
        return app()->getLocale();
    }

}

/**
 * Donne la langue courante
 * 
 * @return array
 */
if (!function_exists('langues_disponibles')) {

    function langues_disponibles() {
        return [
            'fr',
            'en',
        ];
    }

}

/**
 * Jsute pour factoriser le Mail queue et tracker l'erreur pouvant subvenir
 * @param Class $classEnvoi Description
 * @return string
 * */
if (!function_exists('mail_queue')) {

    function mail_queue($classEnvoi) {
        try{
            if (app()->environment() == 'local') {
                \Mail::send($classEnvoi);
            }elseif (app()->environment() == 'production') {
                \Mail::queue($classEnvoi);
            }else{
                \Mail::queue($classEnvoi);
            }
        } catch (Exception $ex) {
            \Log::info($ex->getMessage());
        }
    }

}

/**
 * Préfixe des tables du projet (Application)
 * @return string
 * */
if (!function_exists('prefixe_table')) {

    function prefixe_table() {
        return env('PREFIXE_TABLE', 'dr_');
    }

}

/**
 * Contient
 * 
 * @return boolean
 */
if (!function_exists('contient')) {

    function contient($texte, $rechreche) {
        if (strpos($texte, $rechreche) !== false) {
            return true;
        }
        return false;
    }

}

/**
 * Obtenir les colonnes d'une table donnée de la BD
 * 
 * @param string $nomTable Nom de la table
 * 
 * @return string
 * */
if (!function_exists('colonnes_table_bd')) {

    function colonnes_table_bd($nomTable, $exclureChamps = ['id', 'uuid', 'email_verified_at', 'password', 'remember_token', 'deleted_at']) {
        $colonnes =  \DB::getSchemaBuilder()->getColumnListing($nomTable);
        foreach($exclureChamps as $exclureChamp){
            if (($key = array_search($exclureChamp, $colonnes)) !== false) {
                unset($colonnes[$key]);
            }
        }
        return $colonnes;
    }

}

/**
 * Cette fonction permet de filtrer sur l'objet passé en paramètre puis retourner le builder
 * 
 * @param String $recherche Terme recherché
 * @param Model $objet Objet modèle de transaction en cours
 * @param String $nomRelation Nom de la relation dans le modèe Transaction
 * 
 * @return Builder
 * */
if (!function_exists('filtre_recherche_builder')) {

    function filtre_recherche_builder($recherche, $objet, $itemsBuilder) {
        $nomTableObjet = (new $objet)->getTable();
        $colonnes = colonnes_table_bd($nomTableObjet);
        $colonnes = array_values($colonnes);
        $itemsBuilder->where(function ($q) use ($nomTableObjet, $colonnes, $recherche) {
            $q->when($recherche, function ($query) use ($nomTableObjet, $colonnes, $recherche) {
                foreach ($colonnes as $colonne) {
                    $query->orWhere("$nomTableObjet.$colonne", 'like', '%' . $recherche . '%');
                }
            });
        });

        //\Log::info($itemsBuilder->toSql());
        return $itemsBuilder;
    }

}

/**
 * Taille max fichier en Ko
 * 
 * @return string
 * */
if (!function_exists('taille_max_fichier')) {

    function taille_max_fichier() {
        return 20480;        
    }

}

/**
 * Liste des mimes
 * 
 * @return string
 * */
if (!function_exists('mimes_document')) {

    function mimes_document() {
        return "jpg,jpeg,png,bmp,csv,txt,xlsx,xls,pdf,doc,docx";        
    }

}

/**
 * Liste des mimes image
 * 
 * @return string
 * */
if (!function_exists('mimes_image')) {

    function mimes_image() {
        return "jpg,jpeg,png,bmp,gif";        
    }

}

/**
 * Middleware par défaut pour l'espace admin système
 * 
 * @return Array
 * */
if (!function_exists('middleware_systeme_defaut')) {

    function middleware_systeme_defaut() {
        return ['auth:api', 'verified'];
    }
}

/**
 * Liste des type de notifications envoyées
 * 
 * @return array
 */
if (!function_exists('objet_notification_service')) {

    function objet_notification_service() {
        return [
            'COURRIEL' => __("COURRIEL"),
            'SMS' => __("SMS"),
            'WHATSAPP' => __("WHATSAPP"),
        ];
    }

}

/**
 * Ajouter public/ en production
 * 
 * @return path
 */
    
if (!function_exists('compta_asset')){

    function compta_asset($path) {    
        
        if (app()->environment() == 'production') {
            $path = asset('public/'.$path);
            return $path;
        }
        return asset($path);
    }
}

/**
 * Dernier exercice
 * 
 * @return array
 */
if (!function_exists('last_exercice_id')) {

    function last_exercice_id() {
        try {
            $value = DB::table('exercices')->orderBy('id', 'DESC')->first()->code;
        } catch (\Throwable $th) {
            $value = 0;
        }
        return intval(str_replace("EXC", "", $value));
    }
}

/**
 * Dernière devise
 * 
 * @return array
 */
if (!function_exists('last_devise_id')) {

    function last_devise_id() {
        try {
            $value = DB::table('devises')->orderBy('id', 'DESC')->first()->code;
        } catch (\Throwable $th) {
            $value = 0;
        }        
        return intval(str_replace("DEV", "", $value));
    }
}

/**
 * Dernier journal
 * 
 * @return array
 */
if (!function_exists('last_journal_id')) {

    function last_journal_id() {
        try {
            $value = DB::table('journaux')->orderBy('id', 'DESC')->first()->code;
        } catch (\Throwable $th) {
            $value = 0;
        }
        return intval(str_replace("JNL", "", $value));
    }
}

/**
 * Dernière écriture
 * 
 * @return array
 */
if (!function_exists('last_ecriture_id')) {

    function last_ecriture_id() {
        try {
            $value = DB::table('ecritures')->orderBy('id', 'DESC')->first()->code;
        } catch (\Throwable $th) {
            $value = 0;
        }        
        return intval(str_replace("ECT", "", $value));
    }
}

/**
 * Dernier budget
 * 
 * @return array
 */
if (!function_exists('last_budget_id')) {

    function last_budget_id() {
        try {
            $value = DB::table('budgets')->orderBy('id', 'DESC')->first()->code;
        } catch (\Throwable $th) {
            $value = 0;
        }        
        return intval(str_replace("BDG", "", $value));
    }
}

/**
 * Dernière ligne
 * 
 * @return array
 */
if (!function_exists('last_ligne_id')) {

    function last_ligne_id() {
        try {
            $value = DB::table('lignes')->orderBy('id', 'DESC')->first()->code;
        } catch (\Throwable $th) {
            $value = 0;
        }        
        return intval(str_replace("LGN", "", $value));
    }
}

/**
 * Paramètre
 * 
 * @return array
 */
if (!function_exists('parametre')) {

    function parametre() {
        return Parametre::with(['exercice', 'devise'])->first();
    }
}

/**
 * Un exercice
 * 
 * @return array
 */
if (!function_exists('exercice')) {

    function exercice($uuid) {
        return DB::table('exercices')->where('uuid', $uuid)->first();
    }
}

/**
 * Un exercice
 * 
 * @return array
 */
if (!function_exists('journal')) {

    function journal($id) {
        return DB::table('journaux')->where('id', $id)->first();
    }
}

/**
 * Une devise
 * 
 * @return array
 */
if (!function_exists('devise')) {

    function devise($uuid) {
        return DB::table('devises')->where('uuid', $uuid)->first();
    }
}
    
/**
 * Date transformation
 */
if (!function_exists('date1')){

    function date1($date) {    
        
        return date('d/m/Y à H\hi', strtotime($date));
    }
}

if (!function_exists('date1fr')){

    function date1fr($date) {    
        
        return transD(date('d F Y à H\hi', strtotime($date)));
    }
}

if (!function_exists('date2')){

    function date2($date) {    
        
        return date('d/m/Y', strtotime($date));
    }
}

if (!function_exists('date2fr')){

    function date2fr($date) {    
        
        return transD(date('d F Y', strtotime($date)));
    }
}

if (!function_exists('transD')){
    
    function transD($links) {

        $transliteration = array(
            'Monday' => 'Lundi', 
            'Tuesday' => 'Mardi', 
            'Wednesday' => 'Mercredi', 
            'Thursday' => 'Jeudi', 
            'Friday' => 'Vendredi', 
            'Saturday' => 'Samedi', 
            'Sunday' => 'Dimanche', 
            'January' => 'Janvier', 
            'February' => 'Février', 
            'March' => 'Mars', 
            'April' => 'Avril', 
            'May' => 'Mai', 
            'June' => 'Juin', 
            'July' => 'Juillet', 
            'August' => 'Août',
            'September' => 'Septembre', 
            'October' => 'Octobre', 
            'November' => 'Novembre', 
            'December' => 'Décembre'
        );
        $links = str_replace( array_keys( $transliteration ),
            array_values( $transliteration ),$links);
    
        return htmlspecialchars($links);
    }
}


if (!function_exists('pharmacie')){

    function pharmacie() {  

        $yesterday = (new DateTime())->modify('-1 day')->format('Y-m-d');
        $ecritures = Ecriture::where('journal_id', 1)->whereDate('date', $yesterday)->get();
        $amount = 0;
        foreach ($ecritures as $ecriture) {
            $amount += $ecriture->montant;
        }
        return $amount;
    }
}


if (!function_exists('prestation')){

    function prestation() {  

        $yesterday = (new DateTime())->modify('-1 day')->format('Y-m-d');
        $ecritures = Ecriture::where('journal_id', 2)->whereDate('date', $yesterday)->get();
        $amount = 0;
        foreach ($ecritures as $ecriture) {
            $amount += $ecriture->montant;
        }
        return $amount;
    }
}


if (!function_exists('autre')){

    function autre() {  

        $yesterday = (new DateTime())->modify('-1 day')->format('Y-m-d');
        $ecritures = Ecriture::where([['journal_id', '<>', 1], ['journal_id', '<>', 2]])->whereDate('date', $yesterday)->get();
        $amount = 0;
        foreach ($ecritures as $ecriture) {
            $amount += $ecriture->montant;
        }
        return $amount;
    }
}