

<div class="col-md-12">
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>Name</label>
				<input class="form-control" type="text" name="name" value="{{ checkOld('name', $food) }}" autocomplete="off">
			</div>
			<div class="col-md-6">
				<label>Category</label>
				<select class="form-control" name="category_id" value="{{ checkOld('category_id', $food) }}" autocomplete="off">
					@foreach($categories as $category)
						<option value="{{ $category->id }}" @if($food->category_id == $category->id) selected @endif>{{ $category->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>

	<h3 class="divider first">Nutrients</h3>

	<div class="form-group">
		<div class="row">
			<div class="col-md-3">
				<label>Energy</label>
				<input class="form-control" type="text" name="energy" value="{{ checkOld('energy', $food) }}" autocomplete="off" placeholder="kcal">
			</div>
			<div class="col-md-3">
				<label>Protein</label>
				<input class="form-control" type="text" name="protein" value="{{ checkOld('protein', $food) }}" autocomplete="off" placeholder="g">
			</div>
			<div class="col-md-3">
				<label>Fat</label>
				<input class="form-control" type="text" name="fat" value="{{ checkOld('fat', $food) }}" autocomplete="off" placeholder="g">
			</div>
			
			<div class="col-md-3">
				<label>Sugar</label>
				<input class="form-control" type="text" name="sugar" value="{{ checkOld('sugar', $food) }}" autocomplete="off" placeholder="g">
			</div>
			

		</div>

		
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Carbohydrate</label>
				<input class="form-control" type="text" name="carbohydrate" value="{{ checkOld('carbohydrate', $food) }}" autocomplete="off" placeholder="g">
			</div>
			<div class="col-md-4">
				<label>Salt</label>
				<input class="form-control" type="text" name="salt" value="{{ checkOld('salt', $food) }}" autocomplete="off" placeholder="g">
			</div>
			<div class="col-md-4">
				<label>Fiber</label>
				<input class="form-control" type="text" name="fiber" value="{{ checkOld('fiber', $food) }}" autocomplete="off" placeholder="g">
			</div>
		</div>
	</div>



</div>

