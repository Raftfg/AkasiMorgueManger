<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Exercice;
use Webpatser\Uuid\Uuid;

class ExerciceObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Exercice  $model
     * @return void
     */
    public function creating(Exercice $model) {
        $model->uuid = Uuid::generate();
    }
}
