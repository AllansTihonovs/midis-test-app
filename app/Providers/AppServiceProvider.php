<?php

namespace App\Providers;

use App\Contracts\Admin\AdminServiceInterface;
use App\Services\AdminService;
use App\Contracts\MessageServiceInterface;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(MessageServiceInterface::class, MessageService::class);
        $this->app->bind(AdminServiceInterface::class, AdminService::class);

        Vite::prefetch(concurrency: 3);
    }
}
