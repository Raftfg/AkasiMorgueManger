<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Comptabilite\Entities\Ecriture;
use Modules\Comptabilite\Repositories\AutorisationRepositoryEloquent;

class Facture extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medkey:factures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Récupérer toutes les factures payées dans Medkey';
    protected $autorisationRepositoryEloquent;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AutorisationRepositoryEloquent $autorisationRepositoryEloquent) {
        parent::__construct();
        $this->autorisationRepositoryEloquent = $autorisationRepositoryEloquent;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() 
    {
        $yesterday = (new DateTime())->format('Y-m-d');
        $response = Http::withoutVerifying()->get('https://api-medkey.akasigroup.net/api/v1/getbillsbydate/'.$yesterday); 

        if ($response->successful()) {
            $data = $response->json()['data']; // Get JSON data from the response
            if(!isset($data)){
                return;
            }
            // dd($response->json()['data'][0]);
            for ($i=0; $i < count($data); $i++) { 

                $j = (last_ecriture_id() > 9) ? (last_ecriture_id()+1) : str_pad(last_ecriture_id()+1, 2, "0", STR_PAD_LEFT);
                $attributs['code'] = 'ECT'.$j;
                $attributs['user_id'] = 1;
                $attributs['devise_id'] = 1;    
                $attributs['date'] = $data[$i]['created_at'];                    
                $attributs['libelle'] = $data[$i]['reference'];
                $attributs['montant'] = floatval($data[$i]['montant_total']);
                $attributs['exercice_id'] = exercice_id_by_date($data[$i]['created_at']);

                $verify = Ecriture::where("libelle", $data[$i]['reference'])->get();

                if(count($verify) != 0){
                    continue;
                }

                if($data[$i]['type'] == 'P'){
                    $attributs['journal_id'] = 1;
                    $journal = DB::table('journaux')->where('id', $attributs['journal_id'])->first();
                    $attributs['compte_debit_id'] = $journal->compte_debit_id;
                    $attributs['compte_credit_id'] = $journal->compte_credit_id;
                    $attributs['description'] = 'Facture de médicaments';                     
                }

                if($data[$i]['type'] == 'A'){
                    $attributs['journal_id'] = 2;
                    $journal = DB::table('journaux')->where('id', $attributs['journal_id'])->first();
                    $attributs['compte_debit_id'] = $journal->compte_debit_id;
                    $attributs['compte_credit_id'] = $journal->compte_credit_id;  
                    $attributs['description'] = 'Facture de prestation';                       
                }
                $this->autorisationRepositoryEloquent->create($attributs);
                $attributs = null;
                // Envoyer un mail
            }
        } else {
            $statusCode = $response->status();
            \Log::info($statusCode); 
            // Envoyer un mail  
        }
    }

}
