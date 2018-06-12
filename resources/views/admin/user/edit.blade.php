@extends('layouts.template')

@section('content')
<form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
	<div class="dashboard-header">
		<h1>{{ $user->last_name }} {{ $user->first_name }}</h1>
		<small>Edit user</small>
		<button type="submit" class="btn btn-lg btn-success pull-right" id="submit-form">Save</button>
	</div>

	<div class="dashboard-content">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="hidden" name="id" value="{{ $user->id }}">
		
		@include('admin.user.form')
	</div>
</form>
@endsection