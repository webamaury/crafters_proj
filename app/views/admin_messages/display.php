<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
	<h1 class="pull-left">Message</h1>
	</div>

	<?php echo display_notice(); clear_notice(); ?>
	<div class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>E-mail</th>
					<th>Title</th>
					<th>Message</th>
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
					<td><?php echo $item->message_mail ; ?></td>
					<td><?php echo $item->message_title ; ?></td>
					<td><?php echo substr($item->message_message, 0,100) ; ?> ...</td>
					<td class="colum_action">
						<a href="index.php?module=messages&amp;action=form&amp;id=<?php echo $item->message_id ; ?>" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="More details">
							<span class="glyphicon glyphicon-eye-open"></span>
						</a>&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="delete">
							<span data-toggle="modal" data-target=".bs-example-modal-sm" data-href="index.php?module=messages&amp;action=delete&amp;id=<?php echo $item->message_id ; ?>" class="glyphicon glyphicon-trash modal-supp-trigger"></span>
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
