@extends('layouts.admin')

@section('content')

@include('layouts.common.errors')

<form action="EditMemberConf/{{ $share->id }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Title</label> : <input type="radio" name="Title" value="Mr" <?php if($share->Title=="Mr"){echo "checked";}?>> Mr
									<input type="radio" name="Title" value="Mrs" <?php if($share->Title=="Mrs"){echo "checked";}?>> Mrs <br/><br/>
    <label for="/task">First name</label> : <input type="text" name="FirstName" value={{ $share->FirstName }}><br/><br/>
    <label for="/task">Last name</label> :<input type="text" name="LastName" value={{ $share->LastName }}><br/><br/>
	<label for="/task">Birth date</label> :<input type="date" name="Birth" value={{ $share->birth }}><br/><br/>
	<label for="/task">City</label> :<input type="text" name="City" value={{ $share->City }}><br/><br/>
	<label for="/task">Country</label> :<input type="text" name="Country" value={{ $share->Country }}><br/><br/>
    <label for="/task">Email</label> : <input type="email" name="Mail" value={{ $share->Mail }}	><br/><br/>
	<label for="/task">Phone</label> : <input type="text" name="Phone" value={{ $share->Phone }}><br/><br/>
	How do you prefer us to contact you <select name="PreferC">
											<option value="Phone" {{ $share->PreferC == "phone" ? 'selected' : '' }}>Phone</option>
											<option value="Email" {{ $share->PreferC == "Email" ? 'selected' : '' }}>Email</option>
										</select> <br/><br/>
	Select file to upload (can attach only one):
    <input type="file" name="fileU" id="fileToUpload" ><br/><br/>
    <input type="submit" name="submit" value="Submit"/>
	
</form>

@endsection