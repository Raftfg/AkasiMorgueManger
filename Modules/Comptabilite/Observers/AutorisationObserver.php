<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Autorisation;
use Webpatser\Uuid\Uuid;

class AutorisationObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Autorisation  $model
     * @return void
     */
    public function creating(Autorisation $model) {
        $model->uuid = Uuid::generate();
    }
}
