@extends('layouts.app')

@section('content')

    <p>It's just a form to test<br/>
	Your first name's {{$user['First Name']}}<br/>
	Your last name's {{$user['Last Name']}}<br/>
	Your email is {{$user['Mail']}}<br/>
					
@endsection