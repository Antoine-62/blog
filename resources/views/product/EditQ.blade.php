@extends('layouts.admin')

@section('content')

@include('layouts.common.errors')


	@foreach($fils as $fil)
	<h3>{{$fil->name}}</h3>
	<img src="{{ URL::to('uploads/'.$fil->name)}}" height="100px" width="250px" alt="failure"/> 
 <form action="deleteProductQIm/{{ $fil->id }}" method="POST" onclick="return confirm('Are you sure to delete this product?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Image</button>
	</form>
  @endforeach
  
  <form action="EditProductConf/{{$productQs->id}}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Name</label> : <input type="text" name="Name" value="{{ $productQs->Name }}"><br/><br/>
    <label for="/task">Category</label> :<input type="text" name="Category" value="{{ $productQs->Category }}"><br/><br/>
	<label for="/task">Price</label> :<input type="text" name="Price" value="{{ $productQs->Price }}"><br/><br/>
	Product Status <select name="ProductS">
										<option value="New"{{ $productQs->ProductS === "New" ? 'selected' : '' }}>New</option>
										<option value="Occasion"{{ $productQs->ProductS === "Occasion" ? 'selected' : ''  }}>Occasion</option>
										</select> <br/><br/>
	Select others images to upload :
    <input type="file" name="photos[]" multiple><br/><br/>

    <input type="submit" name="submit" value="Submit"/>
</form>

									
@endsection