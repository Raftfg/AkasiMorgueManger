<?php

use Illuminate\Support\Facades\Route;
use Modules\Document\Http\Controllers\Api\V1\DocumentController;

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
// Route::group(['prefix' => '/{tenant}', 'middleware' => $middlewareBase,], function () use ($middlewareBase) {
    Route::group(['prefix' => 'api'], function () { //CL - Pour garder le même prefixe que les autres routes
        $apiVersion = 'v' . config('premier.api_version');
        Route::group(['prefix' => $apiVersion], function () {  //CL - Pour garder le même prefixe que les autres routes
            Route::group(['middleware' => ['auth:api']], function () {

                //Module Etape
                Route::apiResource('documents', DocumentController::class);
                
            });
        });
    });

// });
