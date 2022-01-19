<?php

namespace App\Repositories;

use App\Models\Purse;

/**
 * Interface PurseRepositoryInterface
 * @package App\Repositories
 */
interface PurseRepositoryInterface extends EloquentRepositoryInterface
{
    /**
    * @param $user_id
    * @return Purse
    */
    public function getByUserId(int $user_id): ?Purse;
}
