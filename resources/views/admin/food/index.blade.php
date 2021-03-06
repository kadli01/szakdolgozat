@extends('layouts.template')

@section('content')
<div class="dashboard-header">
	<h1>Foods</h1>
	<small>Overview, editing</small>
	<a href="{{ route('foods.create') }}" class="btn btn-lg btn-primary pull-right">New</a>
</div>

<div class="dashboard-content">
	<form method="GET" action="{{ route('foods.index') }}" class="form-group">
		<div class="row align-items-end">
			<div class="col-md-4">
				<label for="">Keyword</label>
				<input type="text" name="keyword" class="form-control" placeholder="keyword" value="{{ Request::input('keyword') }}">
			</div>
			<div class="col-md-4">
				<label>Category</label>
				<select name="category" class="form-control">
					{{-- <option value="" selected disabled>Categories</option> --}}
					<option value="">All</option>
					@foreach($categories as $category)
						<option value="{{ $category->id }}" @if(Request::input('category') == $category->id) selected @endif>{{ $category->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-4">
				<button type="submit" name="submit" value="Search" class="btn btn-secondary">Search</button>
			</div>
		</div>
	</form>
	@if(count($foods) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Category</th>
				<th>Energy (kcal)</th>
				<th>Protein (g)</th>
				<th>Fat (g)</th>
				<th>Carbohydrate (g)</th>
				<th>Sugar (g)</th>
				<th>Salt (g)</th>
				<th>Fiber (g)</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($foods as $food)
				<tr>
					<td>{{ $food->id }}</td>
					<td><a href="{{ route('foods.show', ['id' => $food->id]) }}">{{ $food->name }}</a></td>
					<td>{{ $food->category->name }}</td>
					<td>{{ $food->energy }}</td>
					
					<td>{{ $food->protein }}</td>
					<td>{{ $food->fat }}</td>
					<td>{{ $food->carbohydrate }}</td>
					<td>{{ $food->sugar }}</td>
					<td>{{ $food->salt }}</td>
					<td>{{ $food->fiber }}</td>
					<td class="btn-td">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Actions
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
							<li><a href="{{ route('foods.show', ['id' => $food->id]) }}"> View</a></li>
							<li><a href="{{ route('foods.edit', ['id' => $food->id]) }}"> Edit</a></li>
							<form action="{{ route('foods.destroy', ['id' => $food->id]) }}" method="post" enctype="multipart/form-data">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<li>
									<input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this item: {{ $food->name }}?')">
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
		{!! $foods->render() !!}
	</div>
	@else
		<div class="text-center">
			<h3>No items found.</h3>
		</div>
	@endif
</div>
@endsection