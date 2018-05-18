@extends('layouts.template')

@section('content')
	<div class="dashboard-header">
		<h1>{{ $category->name }}</h1>
		<small>View category</small>
		<a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="btn btn-lg btn-primary pull-right">Edit</a>
	</div>

	<div>
		<div class="">
			@include('admin.category.form')
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