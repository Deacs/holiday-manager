<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class LoginController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('login.home');
	}

	/**
	 * Handle an authentication attempt.
	 *
	 * @return Response
	 * @param Request $request
	 * @internal param $email
	 * @internal param $password
	 */
	public function authenticate(Request $request)
	{
		if (Auth::attempt($this->getCredentials($request)))
		{
			return redirect()->intended('member/'.Auth::user()->slug);
		}

		Flash::error('Entered email or password incorrect. Please try again');

		return redirect()->back();
	}

	/**
	 * Log a user out, display notification and return to the home page
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout()
	{
		Auth::logout();

		Flash::success('Successfully logged out');

		return redirect()->route('login.home');
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
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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

	/**
	 * Extract the values from the request that are needed for login
	 * Also include the confirmed check that is only present after confirmation
	 *
	 * @return array
	 * @param Request $request
	 */
	public function getCredentials(Request $request)
	{
		return [
			'email' 	=> $request->input('email'),
			'password' 	=> $request->input('password'),
			'confirmed' => 1
		];
	}

}
