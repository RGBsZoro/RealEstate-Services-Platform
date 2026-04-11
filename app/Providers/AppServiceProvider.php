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
        View::composer('layouts.sections.navbar.navbar-partial', function ($view) {
            if (auth('web')->check()) {
                $user = auth('web')->user();

                $unreadNotificationsCount = $user->unreadNotifications()->count();

                $latestNotifications = $user->notifications()->take(5)->get();

                $view->with(compact('unreadNotificationsCount', 'latestNotifications'));
            }
        });
    }
}
