@extends('layouts.template')

@section('content')
<div class="dashboard-content user-edit">
	<div class="dashboard-header">
		<h1>{{ $food->name }}</h1>
		<small>View item</small>
		<a href="{{ route('foods.edit', ['id' => $food->id]) }}" class="btn btn-lg btn-primary pull-right">Edit</a>
	</div>

	<div>
		<div>
			@include('admin.food.form')
		</div>
	</div>

@endsection

@section('jquery')
	<script>
		$(function(){
			$(':input').each(function(){
				$(this).attr('disabled', 'disabled')
			});

			$(':select').each(function(){
				$(this).attr('disabled', 'disabled')
			});
		});
	</script>
@endsection