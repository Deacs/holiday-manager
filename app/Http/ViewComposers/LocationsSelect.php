<?php namespace App\Http\ViewComposers;

use App\Location as Location;
use Illuminate\Contracts\View\View;

class LocationsSelect {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $locations = Location::all()->lists('name', 'id')->toArray();
        $view->with('locations', $locations);
    }

}
