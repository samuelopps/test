<?php

namespace App\Services;

use App\Models\Transfer;
use App\Repositories\TransferRepositoryInterface;
use App\Services\Interfaces\AuthorizationServiceInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use App\Services\Interfaces\PurseServiceInterface;
use App\Services\Interfaces\TransferServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TransferService
 * @package App\Service
 */
class TransferService implements TransferServiceInterface
{

    /**
     * @var TransferRepositoryInterface
     */
    private TransferRepositoryInterface $transferRepository;

    /**
     * @var PurseServiceInterface
     */
    private PurseServiceInterface $purseService;

    /**
     * @var NotificationServiceInterface
     */
    private NotificationServiceInterface $notificationService;

    /**
     * @var AuthorizationServiceInterface
     */
    private AuthorizationServiceInterface $authorizationService;

    /**
     * PurseService constructor.
     * @param TransferRepositoryInterface $transferRepository
     * @param PurseServiceInterface $purseService
     * @param NotificationServiceInterface $notificationService
     * @param AuthorizationServiceInterface $authorizationService
     */
    public function __construct(
        TransferRepositoryInterface $transferRepository,
        PurseService $purseService,
        NotificationServiceInterface $notificationService,
        AuthorizationServiceInterface $authorizationService
    ) {
        $this->transferRepository = $transferRepository;
        $this->purseService = $purseService;
        $this->notificationService = $notificationService;
        $this->authorizationService = $authorizationService;
    }

    /**
     * Get all transfers
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->transferRepository->all();
    }

    /**
     * Get transfer by Transfer id
     * @param int $transfer_id
     * @return Transfer
     * @throws Exception
     */
    public function find($transfer_id): Transfer
    {
        return $this->transferRepository->find($transfer_id);
    }

    /**
     * Get transfer by Purse id
     * @param int $purse_id
     * @return Collection
     * @throws Exception
     */
    public function getByPurseId(int $purse_id): Collection
    {
        $transfer = $this->transferRepository->getByPurseId($purse_id);
        if (!$transfer)
            throw new Exception('Transfers not found', 404);

        return $transfer;
    }

    /**
     * Get all transfers with status not notified
     * @return Collection
     */
    public function getAllNotNotified(): Collection
    {
        return $this->transferRepository->getAllNotNotified();
    }

    /**
     * Create transfer
     * @param array $transfer
     * @return Transfer
     * @throws Exception
     */
    public function create(array $transfer): Transfer
    {
        $this->validateTransfer($transfer);

        $transfer['status'] = $this->authorizationTransfer() ? 'success' : 'failure';
        $transfer['notified'] = false;

        $created = $this->transferRepository->create($transfer);

        if (!$created) {
            throw new Exception('Failed to create Transfer', 405);
        }

        if ($created->status) {
            $this->subtractBalance($transfer['paying_purse_id'], $created->amount);

            $this->addBalance($transfer['receiver_purse_id'], $created->amount);

            $created->notified = $this->notificationTransfer();
            $created->save();
        }

        return $created;
    }

    //--Commom--

    /**
     * Validacoes to make transfer
     * @return void
     * @throws Exception
     */
    private function validateTransfer(array $transfer)
    {
        $payingPurse = $this->purseService->find($transfer['paying_purse_id']);
        $receiverPurse = $this->purseService->find($transfer['receiver_purse_id']);

        if (!$payingPurse || !$receiverPurse)
            throw new Exception('Purse(s) not found', 409);

        if ($payingPurse->user->profile == 'storekeeper')
            throw new Exception('Tenants only receive transfers', 409);

        if ($transfer['amount'] > $payingPurse->balance)
            throw new Exception('Insufficient balance to make a transfer', 409);
    }

    /**
     * Get external authorizing service query
     * @return bool
     */
    private function authorizationTransfer()
    {
        return $this->authorizationService->getAuthorizationTransfer();
    }

    /**
     * Notification sent by a third party service
     * @return bool
     */
    private function notificationTransfer()
    {
        return $this->notificationService->sendNotificationTransfer();
    }

    private function subtractBalance(
        int $paying_purse_id,
        float $amount)
    {
        $payingPurse = $this->purseService->find($paying_purse_id);
        $payingPurse->balance -= $amount;
        $this->purseService->update($paying_purse_id, $payingPurse->toArray());

        if (!$payingPurse) {
            throw new Exception('Failed to update balance from Paying', 405);
        }
    }

    private function addBalance(
        int $receive_purse_id,
        float $amount)
    {
        $receivePurse = $this->purseService->find($receive_purse_id);
        $receivePurse->balance += $amount;
        $this->purseService->update($receive_purse_id, $receivePurse->toArray());

        if (!$receivePurse) {
            throw new Exception('Failed  to update balance from Receiver', 405);
        }
    }
}
