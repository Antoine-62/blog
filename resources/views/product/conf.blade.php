@extends('layouts.app')

@section('content')

@if (Session::has('message'))
	<div><strong>{{ Session::get('message') }}</strong></div>
@endif

  <h3>Page for user(the next will come soon)</h3>
@endsection