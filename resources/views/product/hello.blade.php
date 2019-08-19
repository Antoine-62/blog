@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')

<h2> Product form (please, don't confuse with a user form, there was a mistake)</h2>


<form action="{{ route('store-user-submit') }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
	<label for="/task">Title</label> : <input type="radio" name="Title" value="Mr" @if(old('Title')=="Mr") checked @endif> Mr
		    <input type="radio" name="Title" value="Mrs"@if(old('Title')=="Mrs") checked @endif> Mrs  <br/><br/>
    <label for="/task">First name</label> : <input type="text" name="FirstName" value="{{ old('FirstName') }}" required="Please fill"/><br/><br/>
    <label for="/task">Last name</label> :<input type="text" name="LastName" value="{{ old('LastName') }}" required="Please fill"/><br/><br/>
	<label for="/task">Birth date</label> :<input type="date" name="Birth" value="{{ old('Birth') }}" required="Please fill"/><br/><br/>
	<label for="/task">City</label> :<input type="text" name="City" value="{{ old('City') }}" required="Please fill"/><br/><br/>
	<label for="/task">Country</label> :<input type="text" name="Country" value="{{ old('Country') }}" required="Please fill"/><br/><br/>
    <label for="/task">Email</label> : <input type="email" name="Mail" value="{{ old('Mail') }}" required="Please fill"/><br/><br/>
	<label for="/task">Phone</label> : <input type="text" name="Phone" value="{{ old('Phone') }}" required="Please fill"/><br/><br/>
	How do you prefer us to contact you <select name="PreferC">
											<option value="Phone"{{ old('PreferC') == "phone" ? 'selected' : '' }}>Phone</option>
											<option value="Email"{{ old('PreferC') == "Email" ? 'selected' : '' }}>Email</option>
										</select> <br/><br/>
										
	Select profile picture to upload (can attach only one):
    <input type="file" name="fileU" id="fileToUpload"><br/><br/>

    <input type="submit" name="submit" value="Submit"/>
</form>


@endsection





