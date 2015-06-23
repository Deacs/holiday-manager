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
		return Department::with('lead')->get();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $slug
	 * @internal param int $id
	 */
	public function show($slug)
	{
		return Department::where('slug', $slug)->with('lead')->with('team')->firstOrFail();
	}

	public function manage($slug)
	{
		dd('Manage root for Department');
	}

	public function team($slug)
	{
		$department = Department::where('slug', $slug)->firstOrFail();
		return $department->team;
	}

}
