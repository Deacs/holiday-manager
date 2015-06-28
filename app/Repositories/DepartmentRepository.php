<?php  namespace App\Repositories;

use App\Department;

class DepartmentRepository
{
    public function getDepartmentBySlug($slug)
    {
        return Department::where('slug', $slug)->with('team')->with('lead')->firstOrFail();
    }

    public function getAllDepartments()
    {
        return Department::all()->with('lead')->get();
    }
}
