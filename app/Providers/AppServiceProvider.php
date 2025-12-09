<?php

namespace App\Providers;

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
        // Register withToast macro for RedirectResponse
        \Illuminate\Http\RedirectResponse::macro('withToast', function ($toast) {
            return $this->with('toast', $toast);
        });
    }
}
