<?php

namespace App\Services\Interfaces;

use App\Models\Purse;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PurseServiceInterface
 * @package App\Service\Interfaces
 */
interface PurseServiceInterface
{

    /**
     * Get all purses
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get purse by user id
     * @param int $user_id
     * @return Collection
     * @throws Exception
     */
    public function getByUserId(int $user_id): ?Purse;

    /**
     * Get purse by id
     * @param int $user_id
     * @return Purse
     * @throws Exception
     */
    public function find(int $purse_id): ?Purse;

    /**
     * Get purses by array of ids
     * @param array $purse_ids
     * @return Collection
     * @throws Exception
     */
    public function findByIds(array $purse_ids): Collection;

    /**
     * Create purse
     * @param array $purse
     * @return Purse
     * @throws Exception
     */
    public function create(array $purse): Purse;

    /**
     * Update purse
     * @param int $purse_id
     * @param array $purse
     * @return Purse
     * @throws Exception
     */
    public function update(int $purse_id, array $purse): ?Purse;
}
