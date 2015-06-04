<?php namespace App\Providers;

use App\User;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any necessary services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe( new UserObserver );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

}
