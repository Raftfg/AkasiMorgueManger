<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Examen;
use Webpatser\Uuid\Uuid;

class ExamenObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Examen  $model
     * @return void
     */
    public function creating(Examen $model) {
        $model->uuid = Uuid::generate();
    }
}
