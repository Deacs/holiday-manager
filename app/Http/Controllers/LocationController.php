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

	public function departments($slug)
	{
		return $this->locationRepository->getLocationBySlug($slug);
	}

	public function departmentTeams($slug)
	{
		return $this->locationRepository->getLocationDepartmentTeams($slug);
//		return Location::where('slug', $location)->with('departments.team')->firstOrFail();
	}

}
