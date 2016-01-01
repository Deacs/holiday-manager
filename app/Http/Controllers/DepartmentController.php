<?php namespace App\Http\Controllers;

use App\Location;
use App\OrgChart;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use App\Department as Department;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
		return view('department.index');
	}

	/**
	 * Display form to create new resource
	 */
	public function create()
	{
		return view('department.add')->with('users', User::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return bool
	 */
	public function store(Request $request)
	{
		if (Gate::denies('add-departments')) {
			abort(403);
		}

		$this->validate($request, [
			'name' 			=> 'required|unique:departments',
			'lead_id' 		=> 'required|integer',
			'location_id' 	=> 'required|integer',
		]);

		// Slug is generated within the LocationObserver
		$department = Department::create($request->all());

		flash()->success('Success!', $department->name.' created');

		return redirect('/departments/'.$department->slug);
	}

	public function listing()
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

	/**
	 * Remove
	 */
	public function manage()
	{
		dd('Manage root for Department');
	}

	public function team($slug)
	{
		$department = Department::where('slug', $slug)->firstOrFail();
		return $department->team;
	}

	/**
	 * Add an new organisation chart to the department
	 *
	 * @param $slug
	 * @param Request $request
	 */
	public function addOrgChart($slug, Request $request)
	{
		$department = Department::where('slug', $slug)->firstOrFail();
		$file 		= $request->file('file');

		// Validate the file type
		$this->validate($request, [
			'file' => 'required|mimes:jpg,jpeg,png,gif'
		]);

		$this->makeOrgChart($file, $department);
	}

	/**
	 * Take an uploaded image and create a new Organisational Chart
	 *
	 * @param UploadedFile $file
	 * @param Department $department
	 */
	protected function makeOrgChart(UploadedFile $file, Department $department)
	{
		$org_chart = OrgChart::fromFile($file, $department->slug)->store($file);

		$department->org_charts()->save($org_chart);
	}

}
