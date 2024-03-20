<?php

namespace Modules\Document\Observers;

use Modules\Document\Entities\Document;
use Webpatser\Uuid\Uuid;

class DocumentObserver {

    /**
     * Handle to the note "creating" event.
     *
     * @param  Document  $model
     * @return void
     */
    public function creating(Document $model) {
        $model->uuid = Uuid::generate();
    }
}
