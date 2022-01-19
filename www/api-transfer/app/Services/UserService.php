<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserService
 * @package App\Service
 */
class UserService implements UserServiceInterface {

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

     /**
     * Get all users
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Get user by id
     * @param int $user_id
     * @return User
     * @throws Exception
     */
    public function find(int $user_id): User
    {
        if ($user_id <= 0)
            throw new Exception('Id invalid', 400);

        return $this->userRepository->find($user_id);
    }

    /**
     * Create user
     * @param array $user
     * @return User
     * @throws Exception
     */
    public function create(array $user): User
    {
        $response = $this->userRepository->create($user);

        if (!$response) {
            throw new Exception('Failed to create User', 405);
        }

        return $response;
    }
}
