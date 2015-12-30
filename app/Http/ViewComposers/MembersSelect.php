<?php namespace App\Http\ViewComposers;

use App\User;
use Illuminate\Contracts\View\View;

class MembersSelect {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $confirmedUsers = User::where('confirmed', 1)->orderBy('last_name')->get();
        $members = [];

        foreach($confirmedUsers as $user) {
            $members[$user->id] = $user->fullName();
        }

        $view->with('members', $members);
    }

}
