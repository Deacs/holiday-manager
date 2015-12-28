<?php  namespace App\Repositories;

use App\User;
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
        // Slug is automatically updated by the Observer, does not need to be managed here
        $user->first_name       = $request['first_name'];
        $user->last_name        = $request['last_name'];
        $user->role             = $request['role'];
        $user->skype_name       = $request['skype_name'];
        $user->telephone        = $request['telephone'];
        $user->extension        = $request['extension'];
        $user->department_id    = $request['department_id'];
        $user->location_id      = $request['location_id'];

        return $user->save();
    }
}
