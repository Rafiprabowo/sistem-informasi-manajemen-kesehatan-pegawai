<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\User;
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
            $users = User::all();
            $view->with('doctors', $doctors);
            $view->with('user', $user);
            $view->with('users', $users);

        });
    }
}
