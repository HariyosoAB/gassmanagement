<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class omMiddleware
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
        if(Auth::user() && (Auth::user()->user_role==3 || Auth::user()->user_role==2)){
           return $next($request);
         }
         return redirect('/login');
    }
}
