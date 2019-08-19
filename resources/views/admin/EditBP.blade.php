@extends('layouts.admin')

@section('content')
	@if (Session::has('message'))
	<div><strong>{{ Session::get('message') }}</strong></div>
 @endif
 
 @include('layouts.common.errors')
 
<h2>Edit a basic page to {{$share->NamePage}}</h2>	


<form action="EditContentConf/{{$share->id}}" id="testformid" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Title</label> : <input type="text" name="Title" value="{{$share->Title }}" required="Please fill"/><br/><br/>
	<label for="/task">Content</label> : <br/><textarea form ="testformid" maxlength="2555" name="Content" id="Content"  rows="15" cols="80" wrap="soft">{{$share->Content }}</textarea>
	<br/>
    <input type="submit" name="submit" value="Submit"/>
</form>

	

@endsection