<?php

use Illuminate\Support\Facades\Route;
use Modules\Comptabilite\Http\Controllers\Api\V1\CorpsController;
use Modules\Comptabilite\Http\Controllers\Api\V1\LigneController;
use Modules\Comptabilite\Http\Controllers\Api\V1\BudgetController;
use Modules\Comptabilite\Http\Controllers\Api\V1\DeviseController;
use Modules\Comptabilite\Http\Controllers\Api\V1\ExamenController;
use Modules\Comptabilite\Http\Controllers\Api\V1\MorgueController;
use Modules\Comptabilite\Http\Controllers\Api\V1\JournalController;
use Modules\Comptabilite\Http\Controllers\Api\V1\EcritureController;
use Modules\Comptabilite\Http\Controllers\Api\V1\ExerciceController;
use Modules\Comptabilite\Http\Controllers\Api\V1\SaccountController;
use Modules\Comptabilite\Http\Controllers\Api\V1\MouvementController;
use Modules\Comptabilite\Http\Controllers\Api\V1\ParametreController;
use Modules\Comptabilite\Http\Controllers\Api\V1\AutorisationController;
use Modules\Comptabilite\Http\Controllers\Api\V1\SaccountClassController;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

// $middlewareBase = tenants_middleware();
// Route::group(['middleware' => $middlewareBase,], function () use ($middlewareBase) {
Route::group(['prefix' => 'api'], function () { //CL - Pour garder le même prefixe que les autres routes
    $apiVersion = 'v' . config('premier.api_version');
    Route::group(['prefix' => $apiVersion], function () {  //CL - Pour garder le même prefixe que les autres routes

        Route::apiResource('exercices', ExerciceController::class);
        Route::apiResource('corpss', CorpsController::class);
        Route::get('corps/total', [CorpsController::class, 'total']);
        Route::apiResource('devises', DeviseController::class);
        Route::apiResource('mouvements', MouvementController::class);
        Route::get('mouvement/total', [MouvementController::class, 'total']);
        Route::apiResource('saccounts', SaccountController::class);
        Route::apiResource('saccount_classes', SaccountClassController::class);
        Route::apiResource('morgues', MorgueController::class);
        Route::apiResource('ecritures', EcritureController::class);
        Route::apiResource('autorisations', AutorisationController::class);
        Route::get('autorisation/total', [AutorisationController::class, 'total']);
        Route::apiResource('journaux', JournalController::class);
        Route::apiResource('examens', ExamenController::class);
        Route::get('examen/total', [ExamenController::class, 'total']);
        Route::apiResource('budgets', BudgetController::class);
        Route::apiResource('lignes', LigneController::class);
        Route::apiResource('parametres', ParametreController::class);
        Route::group(['middleware' => ['auth:api']], function () {
            //D'ici vers le haut ne change pas
            //************************Begin : Module Comptabilite**********************************



            //************************End : Module Comptabilite**********************************
            //D'ici vers le bas ne change pas
        });
    });
});
// });
