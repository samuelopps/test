<?php

namespace App\Repositories\Eloquent;

use App\Models\Purse;
use App\Repositories\PurseRepositoryInterface;

/**
 * Class PurseRepository
 * @package App\Repositories\Eloquent
 */
class PurseRepository extends BaseRepository implements PurseRepositoryInterface
{
    /**
     * PurseRepository constructor.
     *
     * @param Purse $model
     */
    public function __construct(Purse $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $user_id
     * @return Purse
     */
    public function getByUserId(int $user_id): ?Purse
    {
        return $this->model->where('user_id', $user_id)->first();
    }
}
