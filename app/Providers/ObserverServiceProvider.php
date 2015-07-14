<?php namespace App\Providers;

use App\User;
use App\Location;
use App\Observers\UserObserver;
use App\Observers\LocationObserver;
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
        Location::observe( new LocationObserver );
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
