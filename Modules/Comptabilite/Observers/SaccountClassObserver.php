<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\SaccountClass;
use Webpatser\Uuid\Uuid;

class SaccountClassObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  SaccountClass  $model
     * @return void
     */
    public function creating(SaccountClass $model) {
        $model->uuid = Uuid::generate();
    }
}
