<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Corps;
use Webpatser\Uuid\Uuid;

class CorpsObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Corps  $model
     * @return void
     */
    public function creating(Corps $model) {
        $model->uuid = Uuid::generate();
    }
}
