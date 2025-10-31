<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;
class Cors
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
        
        $headers = [
            // 'Access-Control-Allow-Origin' => '*',
            // 'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            // 'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept,Authorization'
        ];

        if ($request->getMethod() == "OPTIONS") {
            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value)
             $response->headers->set($key, $value);
        return $response;
    }
}
