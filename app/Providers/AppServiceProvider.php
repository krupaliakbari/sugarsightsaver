<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Auth::check()):
            if(isset(Auth::user()->profile_image) && Auth::user()->profile_image != ''):
                $profilePath = Auth::user()->profile_image;
            else:
                $profilePath = Vite::asset('resources/images/user-profile.jpeg');
            endif;
        else:
            $profilePath = Vite::asset('resources/images/user-profile.jpeg');
        endif;

        view()->share('profilePath', $profilePath);
    }
}
