<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.dashboard', function ($view) {
            if (! auth()->check()) {
                return;
            }

            $view->with('navbarNotifications', auth()->user()->notifications()->latest()->take(8)->get());
            $view->with('unreadNotificationCount', auth()->user()->unreadNotifications()->count());
        });
    }
}
