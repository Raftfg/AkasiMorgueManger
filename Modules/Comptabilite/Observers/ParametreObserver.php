<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Parametre;
use Webpatser\Uuid\Uuid;

class ParametreObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Parametre  $model
     * @return void
     */
    public function creating(Parametre $model) {
        $model->uuid = Uuid::generate();
    }
}
