@extends('layouts.template')

@section('content')
<form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
	<div class="dashboard-header">
		<h1>Add new item</h1>
		<small>Add new item</small>
		<button type="submit" class="btn btn-lg btn-success pull-right" id="submit-form">Save</button>
	</div>

	<div class="dashboard-content">
		{{ csrf_field() }}
		@include('admin.category.form')
	</div>
</form>
@endsection