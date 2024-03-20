<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Ligne;
use Webpatser\Uuid\Uuid;

class LigneObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Ligne  $model
     * @return void
     */
    public function creating(Ligne $model) {
        $model->uuid = Uuid::generate();
    }
}
