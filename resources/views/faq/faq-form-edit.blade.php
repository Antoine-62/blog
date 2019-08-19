@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')

<form action="confirmation/{{$share->id}}" id="faqForm" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/Question">Question</label> : <input type="text" name="Question" value="{{$share->Question}}" required="Please fill"/><br/><br/>
	<label for="/Answer">Answer</label> : <br/><textarea form ="faqForm" maxlength="2555" name="Answer" id="Content"  rows="15" cols="80" wrap="soft">{{$share->Answer }}</textarea>
	<br/>
	<label for="/Status">Status</label><input type="checkbox" name="Status" value="1" @if($share->Status === "1") checked @endif>
	<br/>
    <input type="submit" name="submit" value="Save"/>
</form>

@endsection