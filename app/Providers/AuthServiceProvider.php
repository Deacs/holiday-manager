<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        // Can the current user edit the member's details
        $gate->define('edit-member', function ($user, $member) {

            // They either own the profile, are the lead of the user's dept or a super user
            if ($user->isSuperUser() || $user->isDepartmentLead($member->department) || $user->id === $member->id) {
                return true;
            }

            return false;
        });

        // Can the current user add new Locations
        $gate->define('add-locations', function ($user) {
            return $user->isSuperUser();
        });
    }
}
