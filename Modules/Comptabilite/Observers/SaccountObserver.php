<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Saccount;
use Webpatser\Uuid\Uuid;

class SaccountObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Saccount  $model
     * @return void
     */
    public function creating(Saccount $model) {
        $model->uuid = Uuid::generate();
    }
}
