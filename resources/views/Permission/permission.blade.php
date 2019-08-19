@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')
<h1>Add Permission </h1>
<h2>Please, select user and basic page</h2>		


<form action="{{ route('AddPermission/Add') }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
	Select user id <select name="User_id">
	@foreach($shares as $share)
					<option value="{{$share->id}}">{{$share->id}}</option>
	@endforeach									
	</select> <br/><br/>
	
	Select Basic Page id<select name="Basic_page_id">
	@foreach($basics as $basic)
					<option value="{{$basic->id}}">{{$basic->slug}}</option>
	@endforeach									
	</select> <br/><br/>
										
    <input  onclick="return confirm('Are you sure about this action ?')" type="submit" name="submit" value="Submit"/>
</form>


@endsection