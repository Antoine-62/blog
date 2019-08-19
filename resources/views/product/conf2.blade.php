@extends('layouts.app')

@section('content')

<form action="{{ route('co3') }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Please your ID :</label> <input type="text" name="id" required="Please fill"/><br/><br/>

    <input type="submit" name="submit" value="Submit"/>
</form>
@endsection