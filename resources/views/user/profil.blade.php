@extends('layouts.admin')

@section('content')


<h3>Profile of {{ $share->name }} :</h3>
	
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
				@else
				<form method="post" action="DeleteVideo/{{$pathVid}}">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
				<video width="320" height="240" controls> <source src="{{ URL::to($pathVid)}}" type="video/webm"></video><br/>
				 <button type="submit">Delete</button>
				</form>@endif
</video> </td>

	@endfor
        </tr>
    </tbody>
  </table>
  <?php 
  
  use Hashids\Hashids;
  
  $hashids = new Hashids('',20);
  $idd = $hashids->encode($share->id);
  ?>
  
  
  
   <form action="UserEdit/{{ $share->slug }}">
	<h4>Edit my profile</h4>
    <button type="submit">Edit</button>
</form>



@endsection