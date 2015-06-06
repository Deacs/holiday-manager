<?php namespace App\Http\Controllers;

use App\User as User;
use App\Http\Requests;
use App\Mailers\AppMailer;
use Illuminate\Support\Facades\App;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {

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
	 * Search for the user with the unconfirmed account that
	 * has the token matching the received version
	 *
	 * @return \Illuminate\View\View
	 * @param $token
	 */
	public function confirm($token)
	{
		$user = User::where('confirmed', false)
					->whereNotNull('confirmation_token')
					->where('confirmation_token', $token)
					->first();

		if ($user) {
			return view('member.complete-confirmation')->with('user_id', $user->id);
		}

		Flash::error('Your account could not be confirmed');
		return view('member.confirm');
	}

	public function completeConfirmation(Request $request)
	{
		$this->validate($request, [
			'password' => 'required|confirmed'
		]);

		$user = User::findOrFail($request->get('user_id'));
		$user->password = bcrypt($request->get('password'));
		$user->confirmAccount();

		Flash::success('Account Successfully Confirmed');

		return redirect('member/'.$user->slug);
	}

}
