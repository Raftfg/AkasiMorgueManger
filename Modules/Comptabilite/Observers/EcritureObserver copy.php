<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Ecriture;
use Webpatser\Uuid\Uuid;

class EcritureObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Ecriture  $model
     * @return void
     */
    public function creating(Ecriture $model) {
        $model->uuid = Uuid::generate();
    }
}
