<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Session;
use Closure;

class hasPermissions
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
        if(auth()->user()->roles()->where('name', 'Admin')->exists()){

		return $next($request);
		}
		$slug=$request->route('slug');
		$basicP = DB::table('basic_page')->where('slug',$slug)->value('id');
		$permission = DB::table('permission')->where('basic_page_id',$basicP)->where('user_id',auth()->user()->getId())->value('id');
		if(isset($permission))
		{
			return $next($request);
		}
        Session::flash('message', "You don't have the permission");
		return redirect('Home2');
    }
}
