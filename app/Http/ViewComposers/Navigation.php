<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Location;

class Navigation {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $locations = Location::with('departments')->get();
        $view->with('locations', $locations);
    }

}
