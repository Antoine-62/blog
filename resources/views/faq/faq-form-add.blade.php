@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')


<form action="{{route('admin/add/faq/confirmation')}}" id="faqForm" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/Question">Question</label> : <input type="text" name="Question" value="{{ old('Question') }}" required="Please fill"/><br/><br/>
	<label for="/Answer">Answer</label> : <br/><textarea form ="faqForm" maxlength="2555" name="Answer" id="Content"  rows="15" cols="80" wrap="soft"></textarea><br/>
	
	<label for="/Status">Status</label><input type="checkbox" name="Status" value="1" @if(is_array(old('Status')) && in_array(1, old('Status'))) checked @endif>
	<br/>
    <input type="submit" name="submit" value="Save"/>
</form>

@endsection