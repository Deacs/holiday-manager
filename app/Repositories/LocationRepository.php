<?php  namespace App\Repositories;

use App\Location;

class LocationRepository
{
    public function getLocationBySlug($slug)
    {
        return Location::where('slug', $slug)->with('departments')->firstOrFail();
    }

    public function getAllLocations()
    {
        return Location::all()->with('lead')->get();
    }

    public function getLocationDepartmentTeams($slug)
    {
        return Location::where('slug', $slug)->with('departments.team')->firstOrFail();
    }

    /**
     * Return all users that are based at this Location
     */
    public function getLocationTeamMembers($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        return $location->users()->get();
    }
}
