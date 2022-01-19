<?php

namespace App\Services;

use App\Models\Purse;
use App\Repositories\PurseRepositoryInterface;
use App\Services\Interfaces\PurseServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PurseService
 * @package App\Service
 */
class PurseService implements PurseServiceInterface
{

    /**
     * @var PurseRepositoryInterface
     */
    private PurseRepositoryInterface $purseRepository;

    /**
     * PurseService constructor.
     * @param PurseRepositoryInterface $purseRepository
     */
    public function __construct(PurseRepositoryInterface $purseRepository)
    {
        $this->purseRepository = $purseRepository;
    }

    /**
     * Get all purses
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->purseRepository->all();
    }

    /**
     * Get purse by user id
     * @param int $user_id
     * @return Collection
     * @throws Exception
     */
    public function getByUserId(int $user_id): ?Purse
    {
        if ($user_id <= 0)
            throw new Exception('User Id invalid', 400);

        $purse = $this->purseRepository->getByUserId($user_id);
        if (!$purse)
            throw new Exception('Purse not found', 404);

        return $purse;
    }

    /**
     * Get purse by id
     * @param int $user_id
     * @return Purse
     * @throws Exception
     */
    public function find(int $purse_id): ?Purse
    {
        if ($purse_id <= 0)
            throw new Exception('Id invalid', 400);

        $purse = $this->purseRepository->find($purse_id);
        if (!$purse)
            throw new Exception('Purse not found', 404);

        return $purse;
    }

    /**
     * Get purses by array of ids
     * @param array $purse_ids
     * @return Collection
     * @throws Exception
     */
    public function findByIds(array $purse_ids): Collection
    {
        $purses = $this->purseRepository->findByIds($purse_ids);
        if (!$purses)
            throw new Exception('Purse not found', 404);

        return $purses;
    }

    /**
     * Create purse
     * @param array $purse
     * @return Purse
     * @throws Exception
     */
    public function create(array $purse): Purse
    {
        $purseExists = $this->purseRepository->getByUserId($purse['user_id']);
        if ($purseExists)
            throw new Exception('There is already a Purse created for this User', 405);

        $response = $this->purseRepository->create($purse);
        if (!$response) {
            throw new Exception('Failed to create Purse', 405);
        }

        return $response;
    }

    /**
     * Update purse
     * @param int $purse_id
     * @param array $purse
     * @return Purse
     * @throws Exception
     */
    public function update(int $purse_id, array $purse): ?Purse
    {
        $this->find($purse_id);

        $updated = $this->purseRepository->update($purse_id, $purse);

        if (!$updated) {
            throw new Exception('Failed to update Purse', 405);
        }

        return $this->find($purse_id);
    }

    /**
     * Delete purse
     * @param int $purse_id
     * @return bool
     * @throws Exception
     */
    public function delete(int $purse_id): bool
    {
        $this->find($purse_id);

        $deleted = $this->purseRepository->delete($purse_id);

        if (!$deleted) {
            throw new Exception('Failed to delete Purse', 405);
        }

        return $deleted;
    }
}
