<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        Auth::viaRequest('admin', function ($request) {
            if (is_null($request->User())) {
                return null;
            } else {
                if ($request->user()->es_admin == 1) {
                    return $request->user();
                } else {
                    return null;
                }

            }

        });
    }
}
