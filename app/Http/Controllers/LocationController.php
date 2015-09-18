<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Location;
use Illuminate\Http\Request;
use App\Repositories\LocationRepository;

class LocationController extends Controller
{

	protected $locationRepository;

	public function __construct(LocationRepository $locationRepository)
	{
		$this->locationRepository = $locationRepository;
	}

	public function index()
	{
		return Location::with('departments.lead')->get();
	}

	public function show($slug)
	{
		$location = Location::where('slug', $slug)->firstOrFail();
		return view('location.home')->with('location', $location)->with('departments', $location->departments);
	}

	/**
	 * @param $slug
	 * @return Location
	 */
	public function profile($slug)
	{
		return $this->locationRepository->getLocationBySlug($slug);
	}

	public function departments($slug)
	{
		return $this->locationRepository->getLocationBySlug($slug);
	}

	public function departmentTeams($slug)
	{
		return $this->locationRepository->getLocationDepartmentTeams($slug);
	}

	public function create()
	{
		return view('location.add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return bool
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' 			=> 'required|unique:locations',
			'address' 		=> 'required',
			'telephone' 	=> 'required',
			'lat' 			=> 'required|numeric',
			'lon' 			=> 'required|numeric',
		]);

		// Slug is generated within the UserObserver
		$location = Location::create($request->all());

		return redirect('/locations/'.$location->slug);
	}

}
