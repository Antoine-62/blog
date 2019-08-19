@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')

<h2>Permissions list</h2>
  <table>
    <thead>
        <tr>
          <td>ID</td>
		  <td>User_Id</td>
          <td>Basic_Page_Id</td>
		  <td>Slug</td>
        </tr>
    </thead>
    <tbody>
        @foreach($shares as $share)
        <tr>
			<td>{{$share->id}}</td>
			<td>{{$share->user_id}}</td>
            <td>{{$share->basic_page_id}}</td>
			<td>{{$share->slug}}</td>
			<td>
				<form action="EditPermission/{{$share->slug}}" method="POST">
					{{ csrf_field() }}
					@method('get')

					<button>Edit Product</button>
				</form>
			</td>
			<td>
				<form action="Delete-permission/{{ $share->id }}" method="POST" onclick="return confirm('Are you sure to delete this permission?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Product</button>
				</form>
			</td>			
        </tr>
        @endforeach
    </tbody>
  </table>
  
@endsection