<?php namespace App\Http\Middleware;

/**
 * Guard against non Super Users performing reserved actions
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class SuperUser {

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
