<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Department as Department;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;

class DepartmentController extends Controller {

	protected $departmentRepository;

	public function __construct(DepartmentRepository $departmentRepository)
	{
		$this->departmentRepository = $departmentRepository;
	}

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
	 * @return $this
	 * @param $slug
	 * @internal param int $id
	 */
	public function show($slug)
	{
		$department = Department::where('slug', $slug)->with('lead')->with('team')->firstOrFail();
//		dd($department);
		return view('department.home')->with('department', $department);
	}

	/**
	 * @param $slug
	 * @return Department
	 */
	public function profile($slug)
	{
		return $this->departmentRepository->getDepartmentBySlug($slug);
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
