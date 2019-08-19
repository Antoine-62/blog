@extends('layouts.admin')


@section('content')
@include('layouts.common.errors')

<h1>Home</h1>
	
 @foreach($shares as $share)
 <?php
	$permission = DB::table('permission')->where('basic_page_id',$share->id)->where('user_id',auth()->user()->getId())->value('id');
	?>
    <h2>{{$share->Title}}</h2><br/>
	<p>{{$share->Content}}<p>
	@if (Auth::user()->isAdmin() or isset($permission))
	<form action="editContent/{{ $share->slug }}" method="POST">
					{{ csrf_field() }}
					@method('get')
					<button>Edit Content</button>
	</form>
	<form action="deleteContent/{{ $share->id }}" method="POST" onclick="return confirm('Are you sure to delete this product?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Content</button>
	</form>
	@endif
@endforeach

@if (Auth::user()->isAdmin())

<?php
$Home2='Home'; ?>

<form action="AddBasicPage/{{$Home2}}" > 
    @method('put')
    @csrf
	<input type="submit" name="submit" value="Add a basic Content"/>
</form>
@endif


@endsection