@extends('layouts.admin')


@section('content')

@if (Session::has('message'))
	<div><strong>{{ Session::get('message') }}</strong></div>
@endif
<h2>Admin Dashboard</h2>

<form action="{{ route('form') }}" >
    @method('put')
    @csrf
    <input type="submit" name="submit" value="Add a new menber(product)"/>
</form>
<form action="MyProfil/{{Auth::user()->id}}" > 
    @method('put')
    @csrf
    <input type="submit" name="submit" value="See my profil"/>
</form>

<form action="{{route('display-User')}}" > 
    @method('put')
    @csrf
	<input type="submit" name="submit" value="See the user registry"/>
</form>

<form action="{{route('display-Member')}}" > 
    @method('put')
    @csrf
	<input type="submit" name="submit" value="Product"/>
</form>

<form action="{{route('AddUser')}}" > 
    @method('put')
    @csrf
	<input type="submit" name="submit" value="AddUser"/>
</form>

<form action="{{route('AddBannerImage')}}" > 
    @method('get')
    @csrf
	<input type="submit" name="submit" value="Add a banner image"/>
</form>


@endsection