<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Location as Location;

class DepartmentsSelect {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $locations = Location::all()->lists('name', 'id');
        $view->with('locations', $locations);
    }

}
