@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')
<h1>Global Variable test </h1>

<form action="changeGlobalVariable" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
	 <label for="/task">Global Variable Value (test)</label> : <input type="text" name="GlobVar" value="{{ $value }}"><br/><br/>
										
    <input  onclick="return confirm('Are you sure to update it ?')" type="submit" name="submit" value="Submit"/>
</form>


@endsection