<?php  namespace App\Repositories; 

use App\Department;
use App\User;

class UserRepository
{
    public function getUserBySlug($slug)
    {
        return User::where('slug', $slug)->with('location')->firstOrFail();
    }

    public function getAllMembers()
    {
        return User::all()->with('department')->with('location')->get();
    }

    public function getAllDepartmentMembersBySlug($slug)
    {
        $department = Department::where('slug', $slug)->firstOrFail();
        return User::where('department_id', $department->id)->with('location')->get();
    }

    public function getAllLocationMembersBySlug($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        return User::where('location_id', $location->id)->with('department')->get();
    }
}
