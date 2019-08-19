<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Session;

class CheckUser
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
		$slug=$request->route('slug');
		$id = DB::table('users')->where('slug',$slug)->value('id');
		if($id == auth()->user()->getId())
		{
			return $next($request);
		}
		Session::flash('message', 'Warning : You tried to logged to another user account!');
		return redirect('Home2');
    }
}
