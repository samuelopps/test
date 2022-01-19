<?php

namespace App\Console\Commands;

use App\Services\Interfaces\NotificationServiceInterface;
use App\Services\Interfaces\TransferServiceInterface;
use Illuminate\Console\Command;

class NotificationTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificationTransfer:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando criado para verificar quais transferencias não foram notificadas e realizar uma nova tentativa';

    private TransferServiceInterface $transferServiceInterface;
    private NotificationServiceInterface $notificationService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        TransferServiceInterface $transferServiceInterface,
        NotificationServiceInterface $notificationService)
    {
        $this->transferServiceInterface = $transferServiceInterface;
        $this->notificationService = $notificationService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     * Command created to check which transfers were not notified and make a new attempt
     */
    public function handle()
    {
        $transfersToNotify = $this->transferServiceInterface->getAllNotNotified();
        foreach ($transfersToNotify as $transfer) {
            $nofitied = $this->notificationService->sendNotificationTransfer();
            $transfer->nofitied = $nofitied;
            $transfer->save();
        }
    }
}
