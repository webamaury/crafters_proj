<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
	<h1 class="pull-left">Admin users</h1>
	<a href="index.php?module=adminUsers&amp;action=form" class="btn btn-primary pull-right margin-top-20"><span class="glyphicon glyphicon-plus font-09em"></span> Add new</a>
	</div>

	<?php echo display_notice(); clear_notice(); ?>
	<div class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>E-mail</th>
					<th class="colum_action">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($items as $item) {
					?>
				<tr>
					<td><?php echo $item->message_id ; ?></td>
					<td><?php echo $item->message_firstname ; ?></td>
					<td><?php echo $item->message_name ; ?></td>
					<td><?php echo $item->message_mail ; ?></td>
					<td class="colum_action">
						<a href="#" onclick="return false" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="send a mail">
							<span data-toggle="modal" data-target=".modal_mail" data-mail="<?php echo $item->message_mail ; ?>" class="glyphicon glyphicon-send modal-supp-trigger"></span>
						</a>&nbsp;&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="see details">
							<span data-toggle="modal" data-target=".modal_fiche" data-id="<?php echo $item->message_id ; ?>" class="glyphicon glyphicon-eye-open modal-fiche-trigger"></span>
						</a>&nbsp;&nbsp;
						<a href="index.php?module=adminUsers&amp;action=form&amp;id=<?php echo $item->message_id ; ?>" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="update">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="delete">
							<span data-toggle="modal" data-target=".bs-example-modal-sm" data-href="index.php?module=adminUsers&amp;action=delete&amp;id=<?php echo $item->message_id ; ?>" class="glyphicon glyphicon-trash modal-supp-trigger"></span>
						</a>
					</td>
				</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_supp.inc.php') ?>
