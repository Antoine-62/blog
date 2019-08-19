
@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')

<h2>Products list (don't confuse with the users list)</h2>
 <a class="navbar-brand" href="{{route('exportProductCSV')}}">Download product list in CSV file</a>
 
 <h3>Upload a CSV file for product list</h3>
 <form action="{{ route('importProductCSV') }}" method="POST" enctype="multipart/form-data">
 @method('put')
 @csrf
     <input type="file" name="file"><br/><br/>
	  <label for="/task">And the images(one for each product) :</label><input type="file" name="photos[]" multiple><br/><br/>

    <input type="submit" name="submit" value="Upload"/>
</form>
  <table>
    <thead>
        <tr>
          <td>ID</td>
		  <td>Title</td>
          <td>First Name</td>
          <td>Last Name</td>
		  <td>Birth Date</td>
          <td>City</td>
          <td>Country</td>
          <td>Email</td>
		  <td>Phone</td>
		  <td>Prefer to be contacted by</td>
		  <td>File Name</td>
		  <td>Image</td>
        </tr>
    </thead>
    <tbody>
        @foreach($shares as $share)
        <tr>
			<td>{{$share->id}}</td>
			<td>{{$share->Title}}</td>
            <td>{{$share->FirstName}}</td>
            <td>{{$share->LastName}}</td>
			<td>{{$share->birth}}</td>
            <td>{{$share->City}}</td>
            <td>{{$share->Country}}</td>
            <td>{{$share->Mail}}</td>
			<td>{{$share->Phone}}</td>
			<td>{{$share->PreferC}}</td>
			<td>{{$share->filename}}</td>
			<td><img src="uploads/{{$share->filename}}" height="50px" width="50px" alt="failure"/></td>
			@if (Auth::user()->isAdmin() or Auth::user()->id == $share->Uid)
			<td>
				<form action="MemberEdit/{{ $share->slug }}" method="POST">
					{{ csrf_field() }}
					@method('get')

					<button>Edit Product</button>
				</form>
			</td>
			<td>
				<form action="Member/{{ $share->id }}" method="POST" onclick="return confirm('Are you sure to delete this product?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Product</button>
				</form>
			</td>	
		@endif			
        </tr>
        @endforeach
    </tbody>
  </table>
  
  
  <h2>ProductQ list (to test the queries Laravel)</h2>
  <a class="navbar-brand" href="{{route('exportProductQCSV')}}">Download productQ list in CSV file</a>
<form action="{{ route('importProductQCSV') }}" method="POST" enctype="multipart/form-data">
 @method('put')
 @csrf
 <h3>Upload a CSV file for productQ list</h3>
     <input type="file" name="file"><br/><br/>

    <input type="submit" name="submit" value="Upload"/>
</form>

  <table>
    <thead>
        <tr>
          <td>ID</td>
		  <td>Name</td>
          <td>Category</td>
          <td>Price (in $)</td>
		  <td>Status</td>
          <td>Image(s)</td>
        </tr>
    </thead>
    <tbody>
        @foreach($productQs as $productQ)
        <tr>
			<td>{{$productQ->id}}</td>
			<td>{{$productQ->Name}}</td>
            <td>{{$productQ->Category}}</td>
            <td>{{$productQ->Price}}$</td>
			<td>{{$productQ->ProductS}}</td>
            <td>@foreach($fils as $fil) @if ($fil->productQ_id == $productQ->id)<img src="uploads/{{$fil->name}}" height="50px" width="50px" alt="failure"/> @endif @endforeach</td>
			@if (Auth::user()->isAdmin() or Auth::user()->id == $productQ->Uid)
			<td>
				<form action="ProductEdit/{{$productQ->slug}}" method="POST">
					{{ csrf_field() }}
					@method('get')

					<button>Edit Product</button>
				</form>
			</td>
			<td>
				<form action="ProductQ/{{$productQ->id}}" method="POST" onclick="return confirm('Are you sure to delete this product?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Product</button>
				</form>
			</td>	
		@endif	
		</tr>
		@endforeach
    </tbody>
  </table>
  




@endsection