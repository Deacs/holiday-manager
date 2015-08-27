<?php namespace App\Http\Middleware;

/**
 * Guard against non Department Leads performing reserved actions
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Department as Department;
use Illuminate\Support\Facades\Auth;

class DepartmentLead {

	/**
	 * The Department
	 *
	 * @var Department
	 */
	protected $department;

	/**
	 * Create a new filter instance.
	 *
	 * @param Department $department
	 * @internal param Guard $auth
	 */
	public function __construct(Department $department)
	{
		$this->department = $department;
	}

	/**
	 * Handle an incoming request.
	 * @return mixed
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 */
	public function handle($request, Closure $next)
	{

		$user 		= Auth::user();
		$department = Department::where('slug', $request->slug)->first();

		if ( ! $user->isDepartmentLead($department)) {
			return redirect()->guest('login');
		}

		return $next($request);
	}

}
