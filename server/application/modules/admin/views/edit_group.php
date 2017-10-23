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
						<h3 class="box-title">Edit group</h3>
					</div>
					<?php echo form_open(uri_string()); ?>
						<div class="box-body">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" name="name" value="<?php echo set_value('name', $group->name); ?>" placeholder="Name" readonly>
							</div>
							<div class="form-group">
								<label for="description">Description</label>
								<input type="text" class="form-control" name="description" value="<?php echo set_value('description', $group->description); ?>" placeholder="Description">
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