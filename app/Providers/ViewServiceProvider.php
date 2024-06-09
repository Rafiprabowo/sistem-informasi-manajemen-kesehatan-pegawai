<?php

namespace App\Providers;

use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {
            $doctors = Doctor::all();
            $user = Auth::user();
            $view->with('doctors', $doctors);
            $view->with('user', $user);
        });
    }
}
