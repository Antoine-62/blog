@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')
<h2>Add a new member</h2>

<form action="{{ route('store-userAdm-submit') }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Name</label> : <input type="text" name="name" value="{{ old('name') }}" required="Please fill this field"/><br/><br/>
    <label for="/task">Email</label> : <input type="email" name="email" value="{{ old('email') }}" required="Please fill this field"/><br/><br/>
	<label for="mdp"> Password : </label><input type="password" name="password" required="Please fill this field"/><br/><br/> 
	<label for="cmdp">Password confirmation : </label><input type="password" name="password_confirmation" required="Please fill this field"/><br/><br/>
	<label for="type">Type : </label><select name="type">
											<option value="2"{{ old('type') == "default" ? 'selected' : ''}}>Default</option>
											<option value="1"{{ old('type') == "admin" ? 'selected' : '' }}>Admin</option>
									</select> <br/><br/>

    <input type="submit" name="submit" value="Submit"/>
</form>



@endsection





