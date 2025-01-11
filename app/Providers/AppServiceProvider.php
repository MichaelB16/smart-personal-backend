<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\StudentRepository;
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
        $this->app->bind(StudentRepository::class, fn() => new StudentRepository(new Student()));
        $this->app->bind(UserRepository::class, fn() => new UserRepository(new User()));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
