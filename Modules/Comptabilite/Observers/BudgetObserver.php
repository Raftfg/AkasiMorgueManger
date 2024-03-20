<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\Budget;
use Webpatser\Uuid\Uuid;

class BudgetObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Budget  $model
     * @return void
     */
    public function creating(Budget $model) {
        $model->uuid = Uuid::generate();
    }
}
