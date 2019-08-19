@extends('layouts.admin')

@section('content')

<a class="navbar-brand" href="{{route('exportUserList')}}">Download the user list in CSV file</a>

 <h3>Upload a CSV file for user list</h3>
 <form action="{{ route('importUserCSV') }}" method="POST" enctype="multipart/form-data">
 @method('put')
 @csrf
     <input type="file" name="file"><br/><br/>

    <input type="submit" name="submit" value="Upload"/>
</form>

<h2>Users List</h2>
  <table>
    <thead>
        <tr>
		  <td>ID</td>
          <td>Name</td>
		  <td>Email</td>
		  <td>Type</td>
		  <td>Video1</td>
		  <td>Video2</td>
		  <td>Video3</td>
		  <td>Video4</td>
		  <td>Video5</td>
        </tr>
    </thead>
    <tbody>
        @foreach($shares as $share)
        <tr>
			<td>{{$share->id}}</td>
			<td>{{$share->name}}</td>
            <td>{{$share->email}}</td>
		 <td>@if ($share->isAdmin())	Admin @else Member @endif	</td>
			@for ($i = 1; $i < 6; $i++)
		<?php
			
				if($i==1)
				{
					$vid='VideoName';
				}
				else
				{
					$vid='VideoName'.$i;
				}
				$pathVid=$share->$vid;
				
		?>
		<td> @if ($pathVid == NULL)	
			<b>No video available</b>
			@else<video width="320" height="240" controls> <source src="{{ URL::to($pathVid)}}" type="video/webm"> @endif
</video> </td>
@endfor
			<td>		
				<form action="UserEdit/{{ $share->slug }}" method="POST">
					{{ csrf_field() }}
					@method('get')

					<button>Edit Member</button>
				</form>
			</td>
			<td>
				<form action="User/{{ $share->id }}" method="POST" onclick="return confirm('Are you sure to delete this user?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Member</button>
				</form>
			</td>			
        </tr>
        @endforeach
    </tbody>
  </table>


@endsection