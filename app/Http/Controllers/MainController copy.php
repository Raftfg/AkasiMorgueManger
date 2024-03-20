<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Modules\Comptabilite\Http\Requests\DeviseRequest;
use Modules\Comptabilite\Http\Requests\JournalRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Comptabilite\Http\Requests\EcritureRequest;
use Modules\Comptabilite\Http\Requests\ExerciceRequest;
use Modules\Comptabilite\Http\Requests\SaccountRequest;
use Modules\Comptabilite\Http\Requests\ParametreRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Document\Repositories\DocumentRepositoryEloquent;
use Modules\Comptabilite\Repositories\LigneRepositoryEloquent;
use Modules\Comptabilite\Repositories\BudgetRepositoryEloquent;
use Modules\Comptabilite\Repositories\DeviseRepositoryEloquent;
use Modules\Comptabilite\Repositories\JournalRepositoryEloquent;
use Modules\Document\Http\Controllers\Api\V1\DocumentController;
use Modules\Comptabilite\Http\Controllers\Api\V1\LigneController;
use Modules\Comptabilite\Repositories\EcritureRepositoryEloquent;
use Modules\Comptabilite\Repositories\ExerciceRepositoryEloquent;
use Modules\Comptabilite\Repositories\SaccountRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\Api\V1\BudgetController;
use Modules\Comptabilite\Http\Controllers\Api\V1\DeviseController;
use Modules\Comptabilite\Repositories\ParametreRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\Api\V1\JournalController;
use Modules\Comptabilite\Http\Controllers\Api\V1\EcritureController;
use Modules\Comptabilite\Http\Controllers\Api\V1\ExerciceController;
use Modules\Comptabilite\Http\Controllers\Api\V1\SaccountController;
use Modules\Comptabilite\Http\Controllers\Api\V1\ParametreController;
use Modules\Comptabilite\Repositories\SaccountClassRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\Api\V1\SaccountClassController;

class MainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 

    protected $ecritureController, $documentController, $exerciceController, $deviseController, $saccountController, 
        $journalController, $ligneController, $budgetController, $parametreController, $saccountClassController;

    public function __construct(EcritureRepositoryEloquent $ecritureRepositoryEloquent, LigneRepositoryEloquent $ligneRepositoryEloquent, 
        DocumentRepositoryEloquent $documentRepositoryEloquent, ExerciceRepositoryEloquent $exerciceRepositoryEloquent, 
        DeviseRepositoryEloquent $deviseRepositoryEloquent, SaccountRepositoryEloquent $saccountRepositoryEloquent, 
        JournalRepositoryEloquent $journalRepositoryEloquent, BudgetRepositoryEloquent $budgetRepositoryEloquent, 
        UserRepositoryEloquent $userRepositoryEloquent, ParametreRepositoryEloquent $parametreRepositoryEloquent, 
        SaccountClassRepositoryEloquent $saccountClassRepositoryEloquent) 
    {
        // parent::__construct();
        $this->saccountController = new SaccountController($saccountRepositoryEloquent, $saccountClassRepositoryEloquent, $userRepositoryEloquent);
        $this->saccountClassController = new SaccountClassController($saccountClassRepositoryEloquent, $userRepositoryEloquent);
        $this->budgetController = new BudgetController($budgetRepositoryEloquent, $exerciceRepositoryEloquent, $userRepositoryEloquent);
        $this->ligneController = new LigneController($ligneRepositoryEloquent, $budgetRepositoryEloquent, $userRepositoryEloquent);
        $this->exerciceController = new ExerciceController($exerciceRepositoryEloquent, $userRepositoryEloquent);
        $this->deviseController = new DeviseController($deviseRepositoryEloquent, $userRepositoryEloquent);
        $this->journalController = new JournalController($journalRepositoryEloquent, $saccountRepositoryEloquent, $userRepositoryEloquent);
        $this->ecritureController = new EcritureController($ecritureRepositoryEloquent, $documentRepositoryEloquent, $exerciceRepositoryEloquent, $deviseRepositoryEloquent, $saccountRepositoryEloquent, $journalRepositoryEloquent, $ligneRepositoryEloquent);
        $this->documentController = new DocumentController($documentRepositoryEloquent); 
        $this->parametreController = new ParametreController($parametreRepositoryEloquent, $exerciceRepositoryEloquent, $deviseRepositoryEloquent, $userRepositoryEloquent);

        if (Cookie::get('access_token') === null){ return redirect('/login'); }
    }   

    // public function __construct(){
    //     $this->middleware('auth');
    // }

    public function index()
    {          
        return view('index', [
            'exercices' => $this->exerciceController->index(),
            'page' => "dashboard",
        ]);
    }


    public function profil()
    {
        return view('profil', [
            // 'user' => User::find(auth_user()->id)
        ]);
    }


    // EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE EXERCICE

    public function exercice_index()
    {
        return view('exercices', [
            'exercices' => $this->exerciceController->index(),
            'page' => "exercice",
        ]);
    }

    public function exercice_store(ExerciceRequest $request)
    {
        $i = (last_exercice_id() > 9) ? (last_exercice_id()+1) : str_pad(last_exercice_id()+1, 2, "0", STR_PAD_LEFT);
        $request['code'] = 'EXC'.$i;

        $exercice = $this->exerciceController->store($request);
        $response = json_decode(json_encode($exercice), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }

    public function exercice_update(ExerciceRequest $request, $uuid)
    {
        $exercice = $this->exerciceController->update($request, $uuid);
        $response = json_decode(json_encode($exercice), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }  
    }

    public function exercice_delete($uuid)
    {
        $exercice = $this->exerciceController->destroy($uuid);
        $response = json_decode(json_encode($exercice), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }


    // DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE

    public function devise_index()
    {
        return view('devises', [
            'devises' => $this->deviseController->index(),
            'page' => "devise",
        ]);
    }

    public function devise_store(DeviseRequest $request)
    {
        $i = (last_devise_id() > 9) ? (last_devise_id()+1) : str_pad(last_devise_id()+1, 2, "0", STR_PAD_LEFT);
        $request['code'] = 'DEV'.$i;

        $devise = $this->deviseController->store($request);
        $response = json_decode(json_encode($devise), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }      
    }

    public function devise_update(DeviseRequest $request, $uuid)
    {
        $devise = $this->deviseController->update($request, $uuid);
        $response = json_decode(json_encode($devise), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }            
    }

    public function devise_delete($uuid)
    {
        $devise = $this->deviseController->destroy($uuid);
        $response = json_decode(json_encode($devise), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }


    // JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL

    public function journal_index($exercice = null)
    {
        if (isset($exercice)) {
            $request = new ParametreRequest ();
            $request['exercice_id'] = $exercice;
            $this->parametreController->update($request, parametre()->uuid);
        }

        return view('journaux', [
            'journaux' => $this->journalController->index(),
            'comptes' => $this->saccountController->index(),
            'exercice' => $exercice,
            'page' => "journal",
        ]);
    }

    public function journal_store(JournalRequest $request)
    {
        $i = (last_journal_id() > 9) ? (last_journal_id()+1) : str_pad(last_journal_id()+1, 2, "0", STR_PAD_LEFT);
        $request['code'] = 'JNL'.$i;

        $journal = $this->journalController->store($request);
        $response = json_decode(json_encode($journal), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }

    public function journal_update(JournalRequest $request, $uuid)
    {
        $journal = $this->journalController->update($request, $uuid);
        $response = json_decode(json_encode($journal), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }  
    }

    public function journal_delete($uuid)
    {
        $journal = $this->journalController->destroy($uuid);
        $response = json_decode(json_encode($journal), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }

    // public function journaux_exercice_index($exercice_uuid)
    // {
    //     return view('journaux', [
    //         'journaux' => $this->journalController->index(),
    //         'comptes' => $this->saccountController->index(),
    //         'exercice_uuid' => $exercice_uuid,
    //     ]);
    // }

    // ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE ECRITURE
    public function ecriture_index($journal = null)
    {
        if (isset($journal)) {
            $ecritures = $this->ecritureController->journal_index($journal);
        } else {
            $ecritures = $this->ecritureController->index();
        }
        return view('ecritures', [
            'ecritures' => $ecritures,
            'journaux' => $this->journalController->index(),
            'lignes' => $this->ligneController->index(),
            'parametre' => $this->parametreController->show(),
            'comptes' => $this->saccountController->index(),
            'journal' => $journal,
            'page' => "ecriture",
        ]);
    }

    public function ecriture_store(EcritureRequest $request)
    {
        $i = (last_ecriture_id() > 9) ? (last_ecriture_id()+1) : str_pad(last_ecriture_id()+1, 2, "0", STR_PAD_LEFT);
        $request['code'] = 'ECT'.$i;

        $ecriture = $this->ecritureController->store($request);
        $response = json_decode(json_encode($ecriture), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }

    public function ecriture_update(EcritureRequest $request, $uuid)
    {
        $ecriture = $this->ecritureController->update($request, $uuid);
        $response = json_decode(json_encode($ecriture), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }  
    }

    public function ecriture_delete($uuid)
    {
        $ecriture = $this->ecritureController->destroy($uuid);
        $response = json_decode(json_encode($ecriture), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }


    // COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE

    public function compte_index()
    {
        return view('comptes', [
            'comptes' => $this->saccountController->index(),
            'classes' => $this->saccountClassController->index(),
            'page' => "compte",
        ]);
    }

    public function compte_store(SaccountRequest $request)
    {
        $compte = $this->saccountController->store($request);
        $response = json_decode(json_encode($compte), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }

    public function compte_update(SaccountRequest $request, $uuid)
    {
        $compte = $this->saccountController->update($request, $uuid);
        $response = json_decode(json_encode($compte), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }  
    }

    public function compte_delete($uuid)
    {
        $compte = $this->saccountController->destroy($uuid);
        $response = json_decode(json_encode($compte), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }        
    }


    // PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE

    public function parametre_index()
    {
        return view('parametres', [
            'parametre' => $this->parametreController->show(),
            'exercices' => $this->exerciceController->index(),
            'devises' => $this->deviseController->index(),
            'page' => "parametre",
        ]);
    }

    public function parametre_update(ParametreRequest $request, $uuid)
    {
        $parametre = $this->parametreController->update($request, $uuid);
        $response = json_decode(json_encode($parametre), true)['original']['data'];

        if(isset($response["resultat"]) && $response["resultat"] == 1){
            return redirect()->back()->with(['success'=> $response['message']]);
        }
        if(isset($response["resultat"]) && $response["resultat"] == 0){
            return redirect()->back()->with(['error'=> $response['message']]);
        }            
    }

    // public function getTransactions($date = null)
    // {
    //     // $response = Http::get('https://api-medkey.akasigroup.net/api/v1/getbillsbydate/'.$date); 
    //     $response = Http::get('https://api-medkey.akasigroup.net/api/v1/getbillsbydate/2023-12-01'); 

    //     if ($response->successful()) {
    //         $data = $response->json(); // Get JSON data from the response
    //         dd($response->json()['data'][0]);
    //         // Process $data as needed
    //         // For example, you can return $data or perform operations on it
    //         return $data;
    //     } else {
    //         // Handle the case where the request was unsuccessful
    //         $statusCode = $response->status(); // Get the HTTP status code
    //         // Log or handle the error accordingly
    //         // For example: return an error message
    //         return "Error: Unable to fetch data. Status code: $statusCode";
    //     }
    // }

}
