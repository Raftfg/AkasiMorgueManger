<?php

namespace Modules\Comptabilite\Repositories;

use App\Repositories\AppBaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;
use Modules\Comptabilite\Entities\Ligne;

/**
 * Class TenantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LigneRepositoryEloquent extends AppBaseRepository implements RepositoryInterface {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Ligne::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot() {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
