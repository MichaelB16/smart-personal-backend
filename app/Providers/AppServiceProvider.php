<?php

namespace App\Providers;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\Repositories\ForgotRepositoryInterface;
use App\Contracts\Repositories\NewPasswordRepositoryInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Repositories\TrainingRepositoryInterface;
use App\Contracts\Repositories\UserGoogleRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\ForgotRepository;
use App\Repositories\NewPasswordRepository;
use App\Repositories\SettingRepository;
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
        $this->app->bind(ForgotRepositoryInterface::class, ForgotRepository::class);
        $this->app->bind(NewPasswordRepositoryInterface::class, NewPasswordRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
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
