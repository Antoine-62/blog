<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class HomeController extends Controller
{
	//use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		/*if(Auth::user()->isAdmin())
		{
			return redirect('BoardAdmin');
		}*/
        return redirect('display-Member');
    }

    /**
     * Determine if the request field is email or username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $field = $this->field($request);

        $messages = ["{$this->username()}.exists" => 'The account you are trying to login is not activated or it has been disabled.'];

        $this->validate($request, [
            $this->username() => "required|exists:users,{$field},active," . User::ACTIVE,
            'password' => 'required',
        ], $messages);
    }
}

