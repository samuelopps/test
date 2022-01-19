<?php

namespace App\Providers;

use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\PurseRepositoryInterface;
use App\Repositories\TransferRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\PurseRepository;
use App\Repositories\Eloquent\TransferRepository;
use Illuminate\Support\ServiceProvider;

/**
* Class RepositoryServiceProvider
* @package App\Providers
*/
class RepositoryServiceProvider extends ServiceProvider
{
   /**
    * Register services.
    *
    * @return void
    */
   public function register()
   {
       $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
       $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
       $this->app->bind(PurseRepositoryInterface::class, PurseRepository::class);
       $this->app->bind(TransferRepositoryInterface::class, TransferRepository::class);
   }
}
