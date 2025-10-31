<?php

namespace App\Http\Middleware;

use Closure;

class StateAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->user()) {
        	warningResponse("Invalid Access Token !");
            return redirect('/login');
        }

        if(in_array($request->user()->user_type_id, [_stateAdminUserTypeId()])) {
            return $next($request);
        }

        return redirect('/');
    }
}
