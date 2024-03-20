<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Modules\Comptabilite\Entities\Morgue;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Modules\Comptabilite\Http\Requests\MouvementRequest;
use Modules\Comptabilite\Http\Requests\MorgueRequest;
use Modules\Comptabilite\Http\Requests\ExamenRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Comptabilite\Http\Requests\AutorisationRequest;
use Modules\Comptabilite\Http\Requests\CorpsRequest;
use Modules\Comptabilite\Http\Requests\SaccountRequest;
use Modules\Comptabilite\Http\Requests\ParametreRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Document\Repositories\DocumentRepositoryEloquent;
use Modules\Comptabilite\Repositories\LigneRepositoryEloquent;
use Modules\Comptabilite\Repositories\BudgetRepositoryEloquent;
use Modules\Comptabilite\Repositories\MouvementRepositoryEloquent;
use Modules\Comptabilite\Repositories\MorgueRepositoryEloquent;
use Modules\Comptabilite\Repositories\ExamenRepositoryEloquent;
use Modules\Document\Http\Controllers\Api\V1\DocumentController;
use Modules\Comptabilite\Http\Controllers\Api\V1\LigneController;
use Modules\Comptabilite\Repositories\AutorisationRepositoryEloquent;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;
use Modules\Comptabilite\Repositories\SaccountRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\Api\V1\BudgetController;
use Modules\Comptabilite\Http\Controllers\Api\V1\MouvementController;
use Modules\Comptabilite\Http\Controllers\Api\V1\MorgueController;
use Modules\Comptabilite\Repositories\ParametreRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\Api\V1\ExamenController;
use Modules\Comptabilite\Http\Controllers\Api\V1\AutorisationController;
use Modules\Comptabilite\Http\Controllers\Api\V1\CorpsController;
use Modules\Comptabilite\Http\Controllers\Api\V1\SaccountController;
use Modules\Comptabilite\Http\Controllers\Api\V1\ParametreController;

class MainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $autorisationController, $documentController, $corpsController, $mouvementController, $saccountController,
        $examenController, $ligneController, $budgetController, $parametreController, $morgueController;

    public function __construct(
        AutorisationRepositoryEloquent $autorisationRepositoryEloquent,
        LigneRepositoryEloquent $ligneRepositoryEloquent,
        DocumentRepositoryEloquent $documentRepositoryEloquent,
        CorpsRepositoryEloquent $corpsRepositoryEloquent,
        MouvementRepositoryEloquent $mouvementRepositoryEloquent,
        SaccountRepositoryEloquent $saccountRepositoryEloquent,
        ExamenRepositoryEloquent $examenRepositoryEloquent,
        BudgetRepositoryEloquent $budgetRepositoryEloquent,
        UserRepositoryEloquent $userRepositoryEloquent,
        ParametreRepositoryEloquent $parametreRepositoryEloquent,
        MorgueRepositoryEloquent $morgueRepositoryEloquent
    ) {
        // parent::__construct();
        $this->saccountController = new SaccountController($saccountRepositoryEloquent, $morgueRepositoryEloquent, $userRepositoryEloquent);
        $this->morgueController = new MorgueController($morgueRepositoryEloquent, $userRepositoryEloquent);
        $this->budgetController = new BudgetController($budgetRepositoryEloquent, $corpsRepositoryEloquent, $userRepositoryEloquent);
        $this->ligneController = new LigneController($ligneRepositoryEloquent, $budgetRepositoryEloquent, $userRepositoryEloquent);
        $this->corpsController = new CorpsController($corpsRepositoryEloquent, $userRepositoryEloquent, $morgueRepositoryEloquent);
        $this->mouvementController = new MouvementController($mouvementRepositoryEloquent,$corpsRepositoryEloquent, $userRepositoryEloquent);
        $this->examenController = new ExamenController($examenRepositoryEloquent, $corpsRepositoryEloquent, $userRepositoryEloquent);
        $this->autorisationController = new AutorisationController($autorisationRepositoryEloquent, $corpsRepositoryEloquent,$userRepositoryEloquent);
        $this->documentController = new DocumentController($documentRepositoryEloquent);
        $this->parametreController = new ParametreController($parametreRepositoryEloquent, $corpsRepositoryEloquent, $mouvementRepositoryEloquent, $userRepositoryEloquent);

        if (Cookie::get('access_token') === null) {
            return redirect('/login');
        }
    }

    // public function __construct(){
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $totalCorps = $this->corpsController->total();
        $totalMouvements = $this->mouvementController->total();
        $totalAutorisations = $this->autorisationController->total();
        $totalExamens = $this->examenController->total();
        return view('index', [
            'exercices' => $this->corpsController->index(),
            // 'total_corps' => $this->corpsController->total(),
            'morgues' => $this->morgueController->index(),
            'totalCorps' => $totalCorps,
            'totalMouvements' => $totalMouvements,
            'totalAutorisations' => $totalAutorisations,
            'totalExamens' => $totalExamens,
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

         // Obtenir le total des corps enregistrés
   
        return view('exercices', [
            'exercices' => $this->corpsController->index(),
            'morgues' => $this->morgueController->index(),
            'page' => "exercice",
            
        ]);
    }

    
    public function exercice_store(CorpsRequest $request)
    {
        // $i = (last_exercice_id() > 9) ? (last_exercice_id() + 1) : str_pad(last_exercice_id() + 1, 2, "0", STR_PAD_LEFT);
        // $request['code'] = 'EXC' . $i;

        $exercice = $this->corpsController->store($request);
        $response = json_decode(json_encode($exercice), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function exercice_update(CorpsRequest $request, $uuid)
    {
        $exercice = $this->corpsController->update($request, $uuid);
        $response = json_decode(json_encode($exercice), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function exercice_delete($uuid)
    {
        $exercice = $this->corpsController->destroy($uuid);
        $response = json_decode(json_encode($exercice), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }


    // DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE DEVISE

    public function devise_index()
    {
        return view('devises', [
            'devises' => $this->mouvementController->index(),
            'corpss' => $this->corpsController->index(),
            'page' => "devise",
        ]);
    }

    public function devise_store(MouvementRequest $request)
    {
      

        $devise = $this->mouvementController->store($request);
        $response = json_decode(json_encode($devise), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function devise_update(MouvementRequest $request, $uuid)
    {
        $devise = $this->mouvementController->update($request, $uuid);
        $response = json_decode(json_encode($devise), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function devise_delete($uuid)
    {
        $devise = $this->mouvementController->destroy($uuid);
        $response = json_decode(json_encode($devise), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }


    // JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL JOURNAL

    public function journal_index()
    {
        // if (isset($exercice)) {
        //     $request = new ParametreRequest();
        //     $request['exercice_id'] = $exercice;
        //     $this->parametreController->update($request, parametre()->uuid);
        // }

        return view('journaux', [
            'journaux' => $this->examenController->index(),
            'corpss' => $this->corpsController->index(),
            'page' => "journal",
        ]);
    }

    public function journal_store(ExamenRequest $request)
    {

        $journal = $this->examenController->store($request);
        $response = json_decode(json_encode($journal), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function journal_update(ExamenRequest $request, $uuid)
    {
        $journal = $this->examenController->update($request, $uuid);
        $response = json_decode(json_encode($journal), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function journal_delete($uuid)
    {
        $journal = $this->examenController->destroy($uuid);
        $response = json_decode(json_encode($journal), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
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
    public function ecriture_index()
    {
       
        return view('ecritures', [
            'ecritures' => $this->autorisationController->index(),
            'corpss' => $this->corpsController->index(),
            'page' => "ecriture",
        ]);
    }

    public function ecriture_store(AutorisationRequest $request)
    {
       

        $ecriture = $this->autorisationController->store($request);
        $response = json_decode(json_encode($ecriture), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function ecriture_update(AutorisationRequest $request, $uuid)
    {
        $ecriture = $this->autorisationController->update($request, $uuid);
        $response = json_decode(json_encode($ecriture), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }

    public function ecriture_delete($uuid)
    {
        $ecriture = $this->autorisationController->destroy($uuid);
        $response = json_decode(json_encode($ecriture), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }


    // COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE COMPTE

    public function compte_index()
    {
        $morgues = Morgue::all();
        return view('comptes', [
            'morgues' => $morgues,
            'page' => "compte",

        ]);
    }

    public function compte_store(MorgueRequest $request)
    {
        // $compte = $this->morgueController->store($request);
        // $response = json_decode(json_encode($compte), true)['original']['data'];

        // if(isset($response["resultat"]) && $response["resultat"] == 1){
        //     return redirect()->back()->with(['success'=> $response['message']]);
        // }
        // if(isset($response["resultat"]) && $response["resultat"] == 0){
        //     return redirect()->back()->with(['error'=> $response['message']]);
        // }   
        // dd($request);   
        $response = $this->morgueController->store($request);
        $responseData = $response['original']['data'];

        if (isset($responseData["resultat"]) && $responseData["resultat"] == 1) {
            return redirect()->back()->with(['success' => $responseData['message']]);
        }
        if (isset($responseData["resultat"]) && $responseData["resultat"] == 0) {
            return redirect()->back()->with(['error' => $responseData['message']]);
        }
    }

    public function compte_update(MorgueRequest $request, $uuid)
    {
        $compte = $this->morgueController->update($request, $uuid);
        $response = json_decode(json_encode($compte), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }


    public function compte_delete($uuid)
    {
        $compte = $this->morgueController->destroy($uuid);
        log::info($compte);
        $response = json_decode(json_encode($compte), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
        }
    }


    // PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE PARAMETRE

    public function parametre_index()
    {
        return view('parametres', [
            'parametre' => $this->parametreController->show(),
            'exercices' => $this->corpsController->index(),
            'devises' => $this->mouvementController->index(),
            'page' => "parametre",
        ]);
    }

    public function parametre_update(ParametreRequest $request, $uuid)
    {
        $parametre = $this->parametreController->update($request, $uuid);
        $response = json_decode(json_encode($parametre), true)['original']['data'];

        if (isset($response["resultat"]) && $response["resultat"] == 1) {
            return redirect()->back()->with(['success' => $response['message']]);
        }
        if (isset($response["resultat"]) && $response["resultat"] == 0) {
            return redirect()->back()->with(['error' => $response['message']]);
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
