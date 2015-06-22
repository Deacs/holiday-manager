<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Location;
use DB;
use Illuminate\Http\Request;

class LocationController extends Controller
{
	/**
	 * Display the specified resource.
	 * @return Response
	 * @param $slug
	 * @internal param int $id
	 */
	public function show($slug)
	{
		$location = Location::where('slug', $slug)->firstOrFail();
		return view('location.home')->with('location', $location)->with('departments', $location->departments);
	}

	public function departments($slug)
	{
		return Location::where('slug', $slug)->with('departments.lead')->firstOrFail();
	}

	public function departmentTeams($location)
	{
		return Location::where('slug', $location)->with('departments.team')->firstOrFail();
	}

}
