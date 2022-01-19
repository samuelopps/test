<?php

namespace App\Services\Interfaces;

/**
 * Interface NotificationServiceInterface
 * @package App\Service\Interfaces
 */
interface NotificationServiceInterface {

    /**
     * Notification sent by a third party service
     * @return bool
     */
    public function sendNotificationTransfer(): bool;
}

