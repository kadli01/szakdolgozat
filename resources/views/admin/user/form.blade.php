
<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>Last name</label>
					<input class="form-control" type="text" name="last_name" value="{{ checkOld('last_name', $user) }}" autocomplete="off">
				</div>
				<div class="col-md-6">
					<label>First name</label>
					<input class="form-control" type="text" name="first_name" value="{{ checkOld('first_name', $user) }}" autocomplete="off">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>Email</label>
					<input disabled class="form-control" type="text" name="email" value="{{ checkOld('email', $user) }}" autocomplete="off">
				</div>
				<div class="col-md-6">
					<label>Phone</label>
					<input class="form-control" type="text" name="phone" value="{{ checkOld('phone', $user) }}" autocomplete="off">
				</div>
			</div>
		</div>
	</div>
</div>

