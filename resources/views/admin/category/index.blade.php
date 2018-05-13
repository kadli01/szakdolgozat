@extends('layouts.template')

@section('content')
<div>
	<h1>Categories</h1>
	<small>Overview, editing</small>
	<a href="{{ route('categories.create') }}" class="btn btn-lg btn-primary pull-right">New</a>
</div>

<div class="dashboard-content">
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Image</th>
				<th>Color</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($categories as $category)
				<tr>
					<td>{{ $category->id }}</td>
					<td><a href="{{ route('categories.show', ['id' => $category->id]) }}">{{ $category->name }}</a></td>
					<td>{{ $category->image }}</td>
					<td>category color?</td>
					<td class="btn-td">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Actions
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
							<li><a href="{{ route('categories.show', ['id' => $category->id]) }}"> View</a></li>
							<li><a href="{{ route('categories.edit', ['id' => $category->id]) }}"> Edit</a></li>
							<form action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="post" enctype="multipart/form-data">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<li>
									<input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this item: {{ $category->name }}?')">
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
		{!! $categories->render() !!}
	</div>
</div>
@endsection