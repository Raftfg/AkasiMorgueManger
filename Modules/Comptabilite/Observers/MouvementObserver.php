<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Mouvement;
use Webpatser\Uuid\Uuid;

class MouvementObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Mouvement  $model
     * @return void
     */
    public function creating(Mouvement $model) {
        $model->uuid = Uuid::generate();
    }
}
