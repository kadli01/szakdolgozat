@extends('layouts.template')

@section('content')
	<div class="dashboard-header">
		<h1>{{ $user->last_name }} {{ $user->first_name }}</h1>
		<small>View user</small>
		<a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-lg btn-primary pull-right">Edit</a>
	</div>

	<div>
		<div class="">
			@include('admin.user.form')
		</div>
	</div>

@endsection

@section('jquery')
	<script>
		$(function(){
			$(':input').each(function(){
				$(this).attr('disabled', 'disabled')
			});
		});
	</script>
@endsection