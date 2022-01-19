<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface TransferRepositoryInterface
 * @package App\Repositories
 */
interface TransferRepositoryInterface extends EloquentRepositoryInterface
{
    /**
    * @param $purse_id
    * @return Collection
    */
    public function getByPurseId(int $purse_id): Collection;

    /**
    * @return Collection
    */
    public function getAllNotNotified(): Collection;
}
