<?php

namespace App\Services\Interfaces;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface TransferServiceInterface
 * @package App\Service\Interfaces
 */
interface TransferServiceInterface {

    /**
     * Get all transfers
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get transfer by Transfer id
     * @param int $transfer_id
     * @return Transfer
     * @throws Exception
     */
    public function find($transfer_id): Transfer;

    /**
     * Get transfer by Purse id
     * @param int $purse_id
     * @return Collection
     * @throws Exception
     */
    public function getByPurseId(int $purse_id): Collection;

    /**
     * Get all transfers with status not notified
     * @return Collection
     */
    public function getAllNotNotified(): Collection;

    /**
     * Create transfer
     * @param array $transfer
     * @return Transfer
     * @throws Exception
     */
    public function create(array $transfer): Transfer;
}

