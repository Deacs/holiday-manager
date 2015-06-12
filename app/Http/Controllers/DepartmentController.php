<?php namespace App\Http\Controllers;

use App\Department as Department;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DepartmentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return 'index for Department';
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 * @param $slug
	 * @internal param int $id
	 */
	public function show($slug)
	{
		$department = Department::where('slug', $slug)->firstOrFail();
		return view('department.home')->with('department', $department)->with('lead', $department->lead)->with('team', $department->team);
	}

	public function manage($slug)
	{
		dd('Manage root for Department');
	}

}
