@extends('layouts.template')

@section('content')
<form action="{{ route('foods.update', ['id' => $food->id]) }}" method="POST" enctype="multipart/form-data">
	<div class="dashboard-header">
		<h1>{{ $food->name }}<h1>
		<small>Edit item</small>
		<button type="submit" class="btn btn-lg btn-success pull-right" id="submit-form">Save</button>
	</div>

	<div>
		<div class="">
			
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			@include('admin.food.form')
		</div>
	</div>
</form>
@endsection