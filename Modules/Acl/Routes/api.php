<?php

use Illuminate\Support\Facades\Route;
use Modules\Acl\Http\Controllers\Api\V1\AuthController;
use Modules\Acl\Http\Controllers\Api\V1\PermissionController;
use Modules\Acl\Http\Controllers\Api\V1\RoleController;
use Modules\Acl\Http\Controllers\Api\V1\UserController;
use Modules\Acl\Http\Controllers\Api\V1\RegisterController;

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


Route::group(['prefix' => 'api'], function () { //CL - Pour garder le même prefixe que les autres routes
    $apiVersion = 'v' . config('premier.api_version');
    Route::group(['prefix' => $apiVersion], function () {  //CL - Pour garder le même prefixe que les autres routes
        Route::group(['prefix' => 'auth', 'middleware' => []], function () {
            Route::post('register', [RegisterController::class, 'store'])->name('register.store');

            Route::post('login', [AuthController::class, 'login']);
            Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot_password');
            Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.password_reset');

            Route::get('email-confirmation/{uuid}', [AuthController::class, 'emailConfirmation'])->name('auth.email_confirmation');
        });

        Route::group(['middleware' => ['auth:api']], function () {

            Route::group(['prefix' => 'auth'], function () {
                Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
                Route::get('user_current', [AuthController::class, 'user'])->name('auth.user');
                Route::post('update_profil', [AuthController::class, 'updateProfil'])->name('auth.update_profil');
                Route::get('show_profil', [AuthController::class, 'showProfil'])->name('auth.show_profil');

                Route::post('renvoi-lien-email-confirmation', [AuthController::class, 'renvoiLienEmailConfirmation'])->name('auth.renvoi_lien_email_confirmation');
                Route::post('envoyer-tel-mobile', [AuthController::class, 'envoyerTelMobile'])->name('auth.envoyer_tel_mobile');
                Route::post('verifier-tel-mobile', [AuthController::class, 'verifierTelMobile'])->name('auth.verifier_tel_mobile');
                Route::get('user-infos-confirmees', [AuthController::class, 'userInfosConfirmees']);
            });
        });

        Route::group(['middleware' => middleware_systeme_defaut()], function () {
            //Module ACL
            Route::post('users/{uuid}/televerser', [UserController::class, 'televerser']);
            Route::post('users/{uuid}/generer-motpasse-temporaire', [UserController::class, 'genererMotPasseTemporaire']);

            Route::apiResource('permissions', PermissionController::class)
                    ->only(['index']); //create and edit sont exclus
            Route::apiResource('roles', RoleController::class); //create and edit sont exclus
            Route::apiResource('users', UserController::class); //create and edit sont exclus
        });
    });
});

