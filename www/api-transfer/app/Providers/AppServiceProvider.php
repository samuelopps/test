<?php

namespace App\Providers;

use App\Services\AuthorizationService;
use App\Services\Interfaces\AuthorizationServiceInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use App\Services\Interfaces\PurseServiceInterface;
use App\Services\Interfaces\TransferServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\NotificationService;
use App\Services\PurseService;
use App\Services\TransferService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(PurseServiceInterface::class, PurseService::class);
        $this->app->bind(TransferServiceInterface::class, TransferService::class);
        $this->app->bind(AuthorizationServiceInterface::class, AuthorizationService::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
