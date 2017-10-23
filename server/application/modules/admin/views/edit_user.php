<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Admin
			<small>Manage accounts</small>
		</h1>
		<br>
		<?php if ($error_message) : ?>
		<div class="alert alert-warning alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-warning"></i> Warning!</h4>
			<?= $error_message ?>
		</div>
		<?php endif ?>
		<?php if ($message) : ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-check"></i> Message!</h4>
				<?= $message ?>
			</div>
		<?php endif ?>
		<?php if ($info) : ?>
			<div class="alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-info"></i> Info!</h4>
				<?= $info ?>
			</div>
		<?php endif ?>
	</section>
    <section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Edit user</h3>
					</div>
					<?php echo form_open(uri_string()); ?>
						<div class="box-body">
							<div class="form-group">
								<label for="first_name">First name</label>
								<input type="text" class="form-control" name="first_name" value="<?php echo set_value('first_name', $user->first_name); ?>" placeholder="First name">
							</div>
							<div class="form-group">
								<label for="last_name">Last name</label>
								<input type="text" class="form-control" name="last_name" value="<?php echo set_value('last_name', $user->last_name); ?>" placeholder="Last name">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" value="<?php echo set_value('email', $user->email); ?>" placeholder="Email">
							</div>
							<h4>Groups</h4>
							<div class="form-group">							
								<?php foreach ($groups as $group) : ?>
									<div class="checkbox">
										<label>
											<?php
											$gID = $group['id'];
											$checked = null;
											$item = null;
											foreach ($currentGroups as $grp)
												{
												if ($gID == $grp->id)
													{
													$checked = ' checked="checked"';
													break;
												}
											}
											?>
											<input type="checkbox" name="groups[]" value="<?= $group['id'] ?>"<?= $checked ?>>
											<?php echo $group['name']; ?>
										</label>
									</div>
								<?php endforeach ?>
							</div>
						</div>
						<div class="box-footer">
							<?= anchor('admin', '<span class="pull-left">Back to the list</span>') ?>
							<button type="submit" class="btn btn-primary btn-flat pull-right">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </section>
</div>