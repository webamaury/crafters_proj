<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
		<h1 class="pull-left">Users</h1>
	</div>

	<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
	<div class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>#</th>
				<th>Mail</th>
				<th>Date</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($items as $item) {
				?>
				<tr>
					<td><?php echo $item->id ; ?></td>
					<td><?php echo $item->mail ; ?></td>
					<td><?php echo $item->date ; ?></td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>
