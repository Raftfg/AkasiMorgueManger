<?php

namespace Modules\Comptabilite\Observers;

use Modules\Comptabilite\Entities\SaccountClass;
use Modules\Comptabilite\Entities\Morgue;
use Webpatser\Uuid\Uuid;

class MorgueObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Morgue  $model
     * @return void
     */
    public function creating(Morgue $model) {
        $model->uuid = Uuid::generate();
    }
}
