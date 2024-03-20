<?php

namespace Modules\Comptabilite\Repositories;

use App\Repositories\AppBaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;
use Modules\Comptabilite\Entities\Corps;

/**
 * Class TenantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CorpsRepositoryEloquent extends AppBaseRepository implements RepositoryInterface {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Corps::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot() {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
