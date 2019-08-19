@extends('layouts.app')

@section('content')

  <h3>You're a member</h3>
<form action="{{ route('display-Member') }}" >
    @method('put')
    @csrf
    <input type="submit" name="submit" value="return to the register"/>
</form>
@endsection