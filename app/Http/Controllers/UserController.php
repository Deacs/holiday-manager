<?php namespace App\Http\Controllers;

use App\User as User;
use App\Http\Requests;
use Laracasts\Flash\Flash;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller {

	protected $userRepository;
	
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}
	
	/**
	 * Return all users
	 */
	public function index()
	{
		return User::with('department')->get();
	}
	
	/**
	 * Return the edit screen
	 *
	 * @param $slug
	 * @return $this
	 */
	public function edit($slug)
	{
		$member = $this->userRepository->getUserBySlug($slug);

		if (Gate::denies('edit-member', $member)) {
			abort(403);
		}

		return view('member.edit')->with('member', $member);
	}

	/**
	 * Return the specified resource.
	 *
	 * @param $slug
	 * @internal param int $id
	 * @return $this
	 */
	public function show($slug)
	{
		$member = $this->userRepository->getUserBySlug($slug);
		return view('member.home')->with('member', $member);
	}

	/**
	 * Update an existing record
	 *
	 * @param Request $request
	 * @param $slug
	 * @internal param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, $slug)
	{
		$user = $this->userRepository->getUserBySlug($slug);

		if (Gate::denies('edit-member', $user)) {
			abort(403);
		}

		if ($this->userRepository->update($user, $request)) {
			Flash::success('Update Successful');
			return redirect('member/'.$user->slug);
		}

		Flash::error('Update Failed');

		Redirect::back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @param AppMailer $mailer
	 * @return bool
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

		return $user;
	}

	public function profile($slug)
	{
		return $this->userRepository->getUserBySlug($slug);
	}

	/**
	 * A valid confirmation request has been received
	 * Validate the request then update the temporary password
	 * Confirm the account - set the confirmed flag, remove the token
	 * Log the user in and redirect to their profile
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @param Request $request
	 */
	public function completeConfirmation(Request $request)
	{
		$this->validate($request, [
			'password' => 'required|confirmed|min:6'
		]);

		$user = User::findOrFail($request->get('user_id'));
		$user->password = bcrypt($request->get('password'));
		$user->confirmAccount();

		Flash::success('Account Successfully Confirmed');
		Auth::login($user);

		return redirect('member/'.$user->slug);
	}

	/**
	 * Search for the user with the unconfirmed account that
	 * has the token matching the received version
	 *
	 * @param $token
	 * @return \Illuminate\View\View
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

}
