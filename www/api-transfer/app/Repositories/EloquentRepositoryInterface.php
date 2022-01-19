<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

    /**
     * @param $ids
     * @return Collection
     */
    public function findByIds(array $ids): Collection;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function update($id, array $attributes): bool;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
