<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/', function () {
//     return response()->json([
//         "message" => __('Formation concept!')
//     ]);
// });

Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
    ], function () {
    
        Route::post('/token', [
            'uses' => 'AccessTokenController@issueToken',
            'as' => 'token',
            'middleware' => 'throttle',
        ]);
    }
);
Route::get('/accueil', function () { return view('accueil'); })->name('accueil');

Route::middleware('verify_token')->group(function () {

    Route::get('/',  [MainController::class, 'index'])->name('dashboard');
    Route::get('/index',  [MainController::class, 'index'])->name('index');
    // Route::get('/balance', function () { return view('balances'); })->name('balance');
    // Route::get('/bilan', function () { return view('bilans'); })->name('bilan');
    // Route::get('/resultat', function () { return view('resultats'); })->name('resultat');
    // Route::get('/budgets', function () { return view('budgets'); })->name('budget');
    Route::get('/balance', function () { return view('waiting', ['page' => "none"]); })->name('balance');
    Route::get('/bilan', function () { return view('waiting', ['page' => "none"]); })->name('bilan');
    Route::get('/resultat', function () { return view('waiting', ['page' => "none"]); })->name('resultat');
    Route::get('/budgets', function () { return view('waiting', ['page' => "none"]); })->name('budget');
    Route::get('/budget/elaboration', function () { return view('budget_elaboration'); })->name('budget.elaboration');
    Route::get('/budget/execution', function () { return view('budget_execution'); })->name('budget.execution');


    // Route::get('/getTransactions',  [MainController::class, 'getTransactions'])->name('transactions.today');

    // EXERCICE
    Route::get('/exercice',  [MainController::class, 'exercice_index'])->name('exercice.index');
    Route::post('/exercice',  [MainController::class, 'exercice_store'])->name('exercice.store');
    Route::put('/exercice/{uuid}',  [MainController::class, 'exercice_update'])->name('exercice.update');
    Route::delete('/exercice/{uuid}',  [MainController::class, 'exercice_delete'])->name('exercice.delete');


    // DEVISE
    Route::get('/devise',  [MainController::class, 'devise_index'])->name('devise.index');
    Route::post('/devise',  [MainController::class, 'devise_store'])->name('devise.store');
    Route::put('/devise/{uuid}',  [MainController::class, 'devise_update'])->name('devise.update');
    Route::delete('/devise/{uuid}',  [MainController::class, 'devise_delete'])->name('devise.delete');


    // JOURNAL
    Route::get('/journal',  [MainController::class, 'journal_index'])->name('journal.index');
    Route::post('/journal',  [MainController::class, 'journal_store'])->name('journal.store');
    Route::put('/journal/{uuid}',  [MainController::class, 'journal_update'])->name('journal.update');
    Route::delete('/journal/{uuid}',  [MainController::class, 'journal_delete'])->name('journal.delete');
    Route::get('/journaux/exercice/{exercice}',  [MainController::class, 'journal_index'])->name('journaux.exercice');


    // ECRITURE
    Route::get('/ecriture',  [MainController::class, 'ecriture_index'])->name('ecriture.index');
    Route::post('/ecriture',  [MainController::class, 'ecriture_store'])->name('ecriture.store');
    Route::put('/ecriture/{uuid}',  [MainController::class, 'ecriture_update'])->name('ecriture.update');
    Route::delete('/ecriture/{uuid}',  [MainController::class, 'ecriture_delete'])->name('ecriture.delete');
    Route::get('/ecritures/journal/{journal}',  [MainController::class, 'ecriture_index'])->name('ecritures.journal');


    // COMPTE
    Route::get('/compte',  [MainController::class, 'compte_index'])->name('compte.index');
    Route::post('/compte',  [MainController::class, 'compte_store'])->name('compte.store');
    Route::put('/compte/{uuid}',  [MainController::class, 'compte_update'])->name('compte.update');
    Route::delete('/compte/{uuid}',  [MainController::class, 'compte_delete'])->name('compte.delete');


    // PARAMETRE
    Route::get('/parametre',  [MainController::class, 'parametre_index'])->name('parametre');
    Route::put('/parametre/{uuid}',  [MainController::class, 'parametre_update'])->name('parametre.update');

    
    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

//Forcer le HTTPS
if (app()->environment() == "production") {
    URL::forceScheme('https');
}

// require __DIR__.'/auth.php';