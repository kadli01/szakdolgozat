@extends('layouts.template')

@section('content')
<form action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
	<div class="dashboard-header">
		<h1>{{ $category->name }}<h1>
		<small>Edit category</small>
		<button type="submit" class="btn btn-lg btn-success pull-right" id="submit-form">Save</button>
	</div>

	<div>
		<div class="">
			
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			@include('admin.category.form')
		</div>
	</div>
</form>
@endsection