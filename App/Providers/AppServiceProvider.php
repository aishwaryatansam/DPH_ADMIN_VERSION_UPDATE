<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
        // CHANGE THIS LINE:
        // Carbon::setLocale(config('app.timezone')); 

        // TO THIS:
        Carbon::setLocale(config('app.locale')); 

        View::composer('*', function ($view) {
            $view->with('user_detail', Auth::user());
        });
    }
}
