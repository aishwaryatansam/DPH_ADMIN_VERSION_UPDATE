<?php

namespace App\Http\Middleware;

use Closure;

class EmployeeAuthMiddleware
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
        if(in_array($request->user()->user_type_id, [_superAdminUserTypeId(),_subAdminUserTypeId(), _employeeUserTypeId(), _districtAdminUserTypeId()])) {
            return $next($request);
        }

        return redirect('/');
    }
}
