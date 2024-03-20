<?php

namespace Modules\Document\Repositories;

use App\Repositories\AppBaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;
use Modules\Document\Entities\Document;

/**
 * Class TenantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DocumentRepositoryEloquent extends AppBaseRepository implements RepositoryInterface {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Document::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot() {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
