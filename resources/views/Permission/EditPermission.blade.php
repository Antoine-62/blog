@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')
<h1>Edit Permission </h1>
<h2>Permission n°{{$permission->id}}</h2>		


<form action="UpdatePermission/{{$permission->id}}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
	Select user id <select name="User_id">
	@foreach($shares as $share)
					<option value="{{$share->id}}"{{ $permission->user_id === $share->id ? 'selected' : '' }}>{{$share->id}}</option>
	@endforeach									
	</select> <br/><br/>
	
	Select Basic Page id<select name="Basic_page_id">
	@foreach($basics as $basic)
					<option value="{{$basic->id}}"{{ $permission->basic_page_id === $basic->id ? 'selected' : '' }}>{{$basic->id}}</option>
	@endforeach									
	</select> <br/><br/>
										
    <input  onclick="return confirm('Are you sure about this action ?')" type="submit" name="submit" value="Submit"/>
</form>


@endsection