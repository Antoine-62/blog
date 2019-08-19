@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')
<p>Form to test Laravel Query </p>
<p>ProductQ form </p>		


<form action="{{ route('store-productQ-submit') }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Product name</label> : <input type="text" name="Name" value="{{ old('Name') }}" required="Please fill"/><br/><br/>
    <label for="/task">Category</label> :<input type="text" name="Category" value="{{ old('Category') }}" required="Please fill"/><br/><br/>
	<label for="/task">Price (in $)</label> :<input type="Number" name="Price" value="{{ old('Price') }}" required="Please fill"/><br/><br/>
	Product Status <select name="ProductS">
										<option value="New"{{ old('PreferC') == "New" ? 'selected' : '' }}>New</option>
										<option value="Occasion"{{ old('PreferC') == "Occasion" ? 'selected' : '' }}>Occasions</option>
										</select> <br/><br/>
										
	Select product pictures to upload:
    <input type="file" name="photos[]" multiple><br/><br/>

    <input type="submit" name="submit" value="Submit"/>
</form>


@endsection
