<?php  namespace App\Repositories;

use App\User;
use App\Department;
use Illuminate\Http\Request;

class UserRepository
{
    public function getUserById($id)
    {
        return User::find($id);
    }

    public function getUserBySlug($slug)
    {
        return User::where('slug', $slug)->with('location')->firstOrFail();
    }

    /**
     * Update an existing user record with the data passed in the request
     *
     * @param User $user
     * @param Request $request
     * @return bool
     */
    public function update(User $user, Request $request)
    {
        $user->first_name       = $request['first_name'];
        $user->last_name        = $request['last_name'];
        $user->role             = $request['role'];
        $user->skype_name       = $request['skype_name'];
        $user->telephone        = $request['telephone'];
        $user->extension        = $request['extension'];
        $user->department_id    = $request['department_id'];
        $user->location_id      = $request['location_id'];

        /* @TODO SLug needs to be recreated - use Observer */

        return $user->save();
    }
    /**
     * @TODO Move to dedicated Repository
     *
     * @param $slug
     * @return
     */
//    public function getAllDepartmentMembersBySlug($slug)
//    {
//        $department = Department::where('slug', $slug)->firstOrFail();
//        return User::where('department_id', $department->id)->with('location')->get();
//    }
//
//    public function getAllMembers()
//    {
//        return User::all()->with('department')->with('location')->get();
//    }

    /**
     * @TODO Move to dedicated Repository
     *
     * @param $slug
     * @return
     */
    public function getAllLocationMembersBySlug($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        return User::where('location_id', $location->id)->with('department')->get();
    }
}
