<?php namespace App\Http\ViewComposers;

use App\Department;
use Illuminate\Contracts\View\View;

class DepartmentsSelect {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $departments = Department::all()->lists('name', 'id');
        $view->with('departments', $departments);
    }

}
