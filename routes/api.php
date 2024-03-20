<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

$apiVersion = 'v' . config('premier.api_version');
Route::group(['prefix' => $apiVersion], function () {  //CL - Pour garder le même prefixe que les autres routes
    require_once("premier/passport.php");
});

//Forcer le HTTPS
if (app()->environment() == "production") {
    URL::forceScheme('https');
}