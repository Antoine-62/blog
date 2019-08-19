<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
       /* if(auth()->user()->isAdmin()) {
        }------------------------->this is for if the function isAdmin() is defined in the user model*/
		if(auth()->user()->roles()->where('name', 'Admin')->exists()){

		return $next($request);
		}
        return redirect('home');
    }
}
