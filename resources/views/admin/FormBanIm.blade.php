@extends('layouts.admin')


@section('content')
@include('layouts.common.errors')
<h2>Add or delete the banner Image</h2>	
@foreach($shares as $share)
   <h3>{{$share->Name}}</h3><br/>
	<img src="uploads/{{$share->Name}}" height="100px" width="300px" alt="failure"/>
	<form action="deleteBannerI/{{ $share->id }}" method="POST" onclick="return confirm('Are you sure to delete this product?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Content</button>
	</form>
@endforeach

<form action="{{ route('AddBannerImage/Add') }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Name</label> : <input type="text" name="Name" value="{{ old('Name') }}" required="Please fill"/><br/><br/>
	Please, select your banner image to upload :
    <input type="file" name="fileBI" id="ImageToUpload"><br/><br/>

    <input type="submit" name="submit" value="Submit"/>
</form>


@endsection