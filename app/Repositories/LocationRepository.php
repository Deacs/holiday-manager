<?php  namespace App\Repositories;

use App\Location;

class LocationRepository
{
    public function getLocationBySlug($slug)
    {
        return Location::where('slug', $slug)->with('departments')->with('departments.lead')->firstOrFail();
    }

    public function getAllLocations()
    {
        return Location::all()->with('lead')->get();
    }

    public function getLocationDepartmentTeams($slug)
    {
        return Location::where('slug', $slug)->with('departments.team')->get();
    }

    public function getLocationDepartmentsByLocationSlug($slug)
    {
        $location = $this->getLocationBySlug($slug);
        return $location->departments;
    }

    /**
     * Return all users that are based at this Location
     *
     * @param $slug
     * return collection
     */
    public function getLocationTeamMembers($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();

        return $location->users()->get();
    }
}
