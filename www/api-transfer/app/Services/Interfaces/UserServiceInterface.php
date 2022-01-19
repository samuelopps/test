<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserServiceInterface
 * @package App\Service\Interfaces
 */
interface UserServiceInterface {

    /**
     * Get all users
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get user by id
     * @param int $user_id
     * @return User
     * @throws Exception
     */
    public function find(int $user_id): User;

    /**
     * Create user
     * @param array $user
     * @return User
     * @throws Exception
     */
    public function create(array $user): User;
}
