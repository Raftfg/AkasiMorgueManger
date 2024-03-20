<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Journal;
use Webpatser\Uuid\Uuid;

class JournalObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Journal  $model
     * @return void
     */
    public function creating(Journal $model) {
        $model->uuid = Uuid::generate();
    }
}
