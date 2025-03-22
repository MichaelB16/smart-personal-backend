<?php

namespace App\Providers;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Repositories\TrainingRepositoryInterface;
use App\Contracts\Repositories\UserGoogleRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TrainingRepository;
use App\Repositories\UserGoogleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(TrainingRepositoryInterface::class, TrainingRepository::class);
        $this->app->bind(UserGoogleRepositoryInterface::class, UserGoogleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
