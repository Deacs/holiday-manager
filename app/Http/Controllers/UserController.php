<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User as User;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class UserController extends Controller {

//	public function gravatar($slug)
//	{
//		$user = User::where('slug', $slug)->firstOrFail();
//
//		$str = md5(trim(strtolower($user->email)));
//
//		print '<img src="http://www.gravatar.com/avatar/'.$str.'" />';
//		$profile = 'http://www.gravatar.com/'.$str.'.php';
//		var_dump(file_get_contents($profile));
//	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 * @param Request $request
	 */
	public function store(Request $request)
	{
		// Slug and initial password are generated within the UserObserver
		User::create($request->all());

		Flash::success('Member Successfully Added');

		return redirect()->back();
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
		$user = User::where('slug', $slug)->firstOrFail();
		return view('member.home')->with('member',$user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
