<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
		// Confirmed account which matches passed credentials
		if (Auth::attempt($this->getCredentials($request))) {
			return redirect()->intended('member/'.Auth::user()->slug);
		}

		// Check for a user with the received email address but not confirmed
		//$confirmed_user = User::where('email', $request->input('email'))->where('confirmed', 1)->first();
		$user = User::where('email', $request->input('email'))->first();

		// Mismatch on email and/or password
		if ( ! $user) {
			flash()->error('Error', 'Entered email or password incorrect. Please try again.');
			return redirect()->back();
		}

		// Have a email password match but not a confirmed account
		if (! $user->isConfirmed()) {
			flash()->error('Error', 'Account has not been confirmed. Please check your email for confirmation details.');
		}

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
