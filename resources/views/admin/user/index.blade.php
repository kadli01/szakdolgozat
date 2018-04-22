@extends('layouts.template')

@section('content')
<div>
	<h1>Users</h1>
	<small>Overview, editing</small>
</div>

<div class="dashboard-content">
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Registration date</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td><a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->last_name }} {{ $user->first_name }}</a></td>
					<td>{{ $user->email }}</td>
					
					<td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
					<td class="btn-td">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Actions
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
							<li><a href="{{ route('users.show', ['id' => $user->id]) }}"> View</a></li>
							<li><a href="{{ route('users.edit', ['id' => $user->id]) }}"> Edit</a></li>
							<form action="{{ route('users.destroy', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<li>
									<input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this user: {{ $user->last_name }} {{ $user->first_name }}?')">
								</li>
							</form>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div class="text-center">
		{!! $users->render() !!}
	</div>
</div>
@endsection