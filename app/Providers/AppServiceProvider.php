<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (env(key: 'APP_ENV') === 'local' && request()->server(key: 'HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme(scheme: 'https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share unread notifications with navbar partial view
        \Illuminate\Support\Facades\View::composer('layouts.partials.navbar', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $notifications = $user->unreadNotifications()->limit(5)->get();
                $unreadCount = $user->unreadNotifications()->count();
                $view->with('notifications', $notifications);
                $view->with('unreadCount', $unreadCount);
            }
        });
    }
}
