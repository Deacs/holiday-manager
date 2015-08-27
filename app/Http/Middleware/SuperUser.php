<?php namespace App\Http\Middleware;

/**
 * Guard against non Super Users performing reserved actions
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class SuperUser {

    /**
     * Create a new filter instance.
     *
     * @param Department $department
     * @internal param Guard $auth
     */
//    public function __construct(Department $department)
//    {
//        $this->department = $department;
//    }

    /**
     * Handle an incoming request.
     * @return mixed
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ( ! $user->isSuperUser()) {
            return redirect()->guest('login');
        }

        return $next($request);
    }

}
