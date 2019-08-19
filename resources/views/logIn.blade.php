@extends('layouts.app')

@section('content')

@if (Session::has('message'))
	<div><strong>{{ Session::get('message') }}</strong></div>
@endif

		<h3> Connexion </h3> <br/>
		<form name="Sign in" method="post" action="{{ route('co') }}">
		 @method('put')
    @csrf
		Email : <input type="text" name="email" required="Please fill this field"/><br/><br/>
		Password : <input type="password" name="password" required="Please fill this field"/><br/><br/>
				<input type="submit" name="log" value="Sign in"/>
		</form>

 <h3> You're not register? Create account here </h3> <br/> 
<form action="{{ route('Registration') }}" >
    @method('put')
    @csrf
    <input type="submit" name="submit" value="Next"/>
</form>
@endsection