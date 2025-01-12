<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class ApiController extends Controller {
    protected $nombrePage = 25;
    protected $moduleAlias, $mediaCollectionName, $mediaDisk;
    protected $messageSuppressionPossibleOui = "Item supprimé avec succès";
    public function __construct() {
        $this->nombrePage = config('premier.nombre_pagination');
    }
    
}
