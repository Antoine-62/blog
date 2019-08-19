@extends('layouts.admin')


@section('content')

@include('layouts.common.errors')

<h2>FAQ</h2>

  <table>
    <thead>
        <tr>
          <td>Number</td>
		  <td>Question</td>
          <td>Answer</td>
          <td>Status</td>
        </tr>
    </thead>
    <tbody>
        @foreach($shares as $share)
        <tr>
			<td>{{$share->id}}</td>
			<td>{{$share->Question}}</td>
            <td>{{$share->Answer}}</td>
            <td>{{$share->Status}}</td>
			@if (Auth::user()->isAdmin())
			<td>
				<form action="admin/edit/faq/{{$share->slug}}" method="POST">
					{{ csrf_field() }}
					@method('get')

					<button>Edit Question</button>
				</form>
			</td>
			<td>
				<form action="Delete-Question/{{$share->id}}" method="POST" onclick="return confirm('Are you sure to delete this product?')">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button>Delete Question</button>
				</form>
			</td>	
		@endif			
        </tr>
        @endforeach
    </tbody>
  </table>
  
  
@endsection