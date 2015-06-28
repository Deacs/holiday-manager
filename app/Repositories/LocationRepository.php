<?php  namespace App\Repositories;

use App\Location;

class LocationRepository
{
    public function getLocationBySlug($slug)
    {
        return Location::where('slug', $slug)->with('departments')->with('lead')->firstOrFail();
    }

    public function getAllLocations()
    {
        return Location::all()->with('lead')->get();
    }

    public function getLocationDepartmentTeams($slug)
    {
        return Location::where('slug', $slug)->with('departments.team')->firstOrFail();
    }
}
