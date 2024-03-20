<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Devise;
use Webpatser\Uuid\Uuid;

class DeviseObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Devise  $model
     * @return void
     */
    public function creating(Devise $model) {
        $model->uuid = Uuid::generate();
    }
}
