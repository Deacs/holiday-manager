<?php namespace App\Http\Middleware;

/**
 * Guard against no Department Leads performing reserved actions
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
	 * @param $department_id
	 */
	public function handle($request, Closure $next, $department_id = 2)
	{
//		if ($this->auth->guest())
//		{
//			if ($request->ajax())
//			{
//				return response('Unauthorized.', 401);
//			}
//			else
//			{
//				return redirect()->guest('login');
//			}
//		}


		$user 		= Auth::user();
		$department = Department::findOrFail($department_id);

		//dd($department);

		if ( ! $user->isDepartmentLead($department)) {
			return redirect()->guest('login');
		}
		//dd($this->department);

		return $next($request);
	}

}
