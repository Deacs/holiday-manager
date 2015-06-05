<?php namespace App\Http\Controllers;

use App\User as User;
use App\Http\Requests;
use App\Mailers\AppMailer;
use Illuminate\Support\Facades\App;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
	 * @param AppMailer $mailer
	 */
	public function store(Request $request, AppMailer $mailer)
	{
		$this->validate($request, [
			'first_name' 	=> 'required',
			'last_name' 	=> 'required',
			'email' 		=> 'required|email|unique:users',
			'role' 			=> 'required',
			'department_id' => 'required|integer',
			'location_id' 	=> 'required|integer',
		]);

		// Slug, initial password and confirmation token are generated within the UserObserver
		$user = User::create($request->all());

		// Email a confirmation link to the newly created user
		$mailer->sendConfirmationRequestEmail($user);

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
	 *
     */
	public function confirm($token)
	{
		$user = User::where('confirmed', false)
					->whereNotNull('confirmation_token')
					->where('confirmation_token', $token)
					->first();

		if ($user) {
			Flash::success('Account successfully confirmed');
			return $user->confirmAccount();
		}

		Flash::error('Your account could not be confirmed');
		return view('member.confirm');
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
