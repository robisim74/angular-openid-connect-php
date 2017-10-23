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
        	<div class="col-sm-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Users</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-4">
								<?php echo anchor("admin/register", '<button class="btn btn-primary btn-block btn-flat"> Register new user</button>'); ?>
							</div>
						</div>
						<br>
						<table id="users-table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Last name</th>
									<th>First name</th>
									<th>Email</th>
									<th>Groups</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($users as $user) : ?>
									<tr>
										<td><?php echo $user->last_name; ?></td>
										<td><?php echo $user->first_name; ?></td>
										<td><?php echo mailto($user->email, $user->email); ?></td>
										<td>
											<?php $i = 1;
											foreach ($user->groups as $group) : ?>
												<?php 
												$sep = ($i++ != count($user->groups)) ? ',' : '';
												echo anchor("admin/edit_group/" . $group->id, $group->name) . $sep;
												?>
											<?php endforeach ?>
										</td>
										<td class="text-center">
											<div class="dropdown">
												<button class="btn btn-<?php echo ($user->active) ? 'success' : 'danger'; ?> btn-xs" dropdown-toggle type="button"  data-toggle="dropdown">
													<?php echo ($user->active) ? 'Active' : 'Deactivated'; ?>
													<span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<?php if ($user->active) : ?>
														<li><?php echo anchor("admin/deactivate_user/" . $user->id, 'Deactivate'); ?></li>
													<?php  else : ?>
														<li><?php echo anchor("admin/activate_user/" . $user->id, 'Activate'); ?></li>
													<?php endif ?>
												</ul>
											</div>
										</td>
										<td class="text-center">
											<?php echo anchor("admin/edit_user/" . $user->id, '<button class="btn btn-primary btn-xs"><span class="fa fa-edit"></span> Edit</button>'); ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
    </section>
</div>