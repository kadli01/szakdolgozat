

<div class="col-md-12">
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>Name</label>
				<input class="form-control" type="text" name="name" value="{{ checkOld('name', $category) }}" autocomplete="off">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>Image</label>
				<input class="form-control" type="file" name="image" value="{{ checkOld('image', $category) }}" autocomplete="off" placeholder="kcal">
			</div>	
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Color</label>
				<input class="form-control" type="color" name="color" value="{{ checkOld('color', $category) }}" autocomplete="off" placeholder="color">
			</div>
		</div>
	</div>



</div>

