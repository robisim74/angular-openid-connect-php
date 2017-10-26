<div class="d-flex flex-row flex-wrap justify-content-md-between align-items-center">
	<div class="p-2">
		<h1>
			Admin panel
			<small class="text-muted">List of users</small>
		</h1>
	</div>
	<div class="p-2">
		<?php echo anchor("admin/register", '<button class="btn btn-primary">Register</button>'); ?>
	</div>
</div>
<br>
<table id="users-table" class="table table-striped table-bordered">
	<thead class="thead-dark">
		<tr>
			<th scope="col">Last name</th>
			<th scope="col">First name</th>
			<th scope="col">Email</th>
			<th scope="col">Groups</th>
			<th scope="col" class="text-center">Status</th>
			<th scope="col" class="text-center"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user) : ?>
			<tr>
				<th scope="row"><?php echo $user->last_name; ?></th>
				<td><?php echo $user->first_name; ?></td>
				<td><?php echo mailto($user->email, $user->email); ?></td>
				<td>
					<?php $i = 1;
					foreach ($user->groups as $group) : ?>
						<?php 
						$sep = ($i++ != count($user->groups)) ? ',' : '';
						echo $group->name . $sep;
						?>
					<?php endforeach ?>
				</td>
				<td class="text-center">
					<div class="btn-group">
						<button class="btn btn-<?php echo ($user->active) ? 'success' : 'danger'; ?> btn-sm" type="button">
							<?php echo ($user->active) ? 'Active' : 'Deactivated'; ?>
						</button>
						<button type="button" class="btn btn-sm btn-<?php echo ($user->active) ? 'success' : 'danger'; ?> dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
						<div class="dropdown-menu">
							<?php if ($user->active) : ?>
								<?php echo anchor("admin/deactivate_user/" . $user->id, 'Deactivate', array('class' => 'dropdown-item')); ?>
							<?php  else : ?>
								<?php echo anchor("admin/activate_user/" . $user->id, 'Activate', array('class' => 'dropdown-item')); ?>
							<?php endif ?>
						</div>
					</div>
				</td>
				<td class="text-center">
					<?php echo anchor("admin/edit_user/" . $user->id, '<button class="btn btn-primary btn-sm">Edit</button>'); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>