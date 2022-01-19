<?php

namespace App\Services;

use App\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Support\Facades\Http;

/**
 * Class NotificationService
 * @package App\Service
 */
class NotificationService implements NotificationServiceInterface
{
    /**
     * @var string
     */
    private $urlNotification;

    /**
     * NotificationService constructor.
     */
    public function __construct()
    {
        $this->urlNotification = env('URL_NOTIFICATION_SERVICE');
    }

    /**
     * Notification sent by a third party service
     * @return bool
     */
    public function sendNotificationTransfer(): bool
    {
        $response = Http::post($this->urlNotification);

        return $response->successful();
    }
}
