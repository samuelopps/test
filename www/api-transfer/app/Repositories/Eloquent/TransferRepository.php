<?php

namespace App\Repositories\Eloquent;

use App\Models\Transfer;
use App\Repositories\TransferRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TransferRepository
 * @package App\Repositories\Eloquent
 */
class TransferRepository extends BaseRepository implements TransferRepositoryInterface
{
    /**
     * TransferRepository constructor.
     *
     * @param Transfer $model
     */
    public function __construct(Transfer $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $purse_id
     * @return Collection
     */
    public function getByPurseId(int $purse_id): Collection
    {
        return $this->model
            ->where('paying_purse_id', $purse_id)
            ->orWhere('receiver_purse_id', $purse_id)->get();
    }

    /**
     * @return Collection
     */
    public function getAllNotNotified(): Collection
    {
        return $this->model
            ->where(['status' => 'success', 'notified' => false])->get();
    }
}
