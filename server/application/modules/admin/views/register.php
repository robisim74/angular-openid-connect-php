<div class="d-flex flex-row flex-wrap justify-content-md-between align-items-center">
	<div class="p-2">
		<h1>
			Admin panel
			<small class="text-muted">Register</small>
		</h1>
	</div>
	<div class="p-2">
		<?php echo anchor("admin", '<button class="btn btn-primary"> Back to the list</button>'); ?>
	</div>
</div>
<br>
<div class="container">
	<?php echo form_open("admin/register", array('id' => 'registerForm', 'novalidate' => '')) ?>
		<?php if ($error_message) : ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<h4><i class="fa fa-warning"></i> Warning!</h4>
				<?= $error_message ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif ?>
		<div class="form-group row">
			<label for="first_name" class="col-lg-2 col-form-label">First name</label>
			<div class="col-lg-10">
				<input type="text" id="first_name" class="form-control" name="first_name" value="<?php echo set_value('first_name'); ?>" placeholder="First name">
			</div>
		</div>
		<div class="form-group row">
			<label for="last_name" class="col-lg-2 col-form-label">Last name</label>
			<div class="col-lg-10">
				<input type="text" id="last_name" class="form-control" name="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Last name">
			</div>
		</div>
		<div class="form-group row">
			<label for="email" class="col-lg-2 col-form-label">Email</label>
			<div class="col-lg-10">
				<input type="email" id="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email">
			</div>
		</div>
		<div class="form-group row">
			<label for="password" class="col-lg-2 col-form-label">Password</label>
			<div class="col-lg-10">
				<input type="password" id="password" class="form-control" name="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
			</div>
		</div>
		<div class="form-group row">
			<label for="password_confirm" class="col-lg-2 col-form-label">Confirm password</label>
			<div class="col-lg-10">
				<input type="password" id="password_confirm" class="form-control" name="password_confirm" value="<?php echo set_value('password_confirm'); ?>" placeholder="Confirm password">
			</div>
		</div>
		<div class="form-group row justify-content-end">
			<div class="col-lg-4">
				<button type="submit" class="btn btn-primary btn-block">Save</button>
			</div>
		</div>
	</form>
</div>