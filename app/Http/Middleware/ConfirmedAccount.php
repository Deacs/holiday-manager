<?php namespace App\Http\Middleware;

use Closure;
use App\User;
use Laracasts\Flash\Flash;

class ConfirmedAccount {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = User::where('email', $request->input('email'))->where('confirmed', 1)->first();

		if ($user) {
			return $next($request);
		}

		Flash::error('Account has not been confirmed. Please check your email for confirmation details.');
		return redirect()->back();
	}

}
