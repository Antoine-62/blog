@extends('layouts.app')

@section('content')


<form action="{{ route('form') }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">How old are you :</label> <input type="text" name="age" required="Please fill"/><br/><br/>

    <input type="submit" name="submit" value="Submit"/>
</form>




@endsection





