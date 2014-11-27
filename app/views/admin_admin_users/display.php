<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
	<h1 class="pull-left">Admin users</h1>
	<a href="index.php?module=admin_users&display=form" class="btn btn-primary pull-right margin-top-20">Nouveau</a>
	</div>

	<?php echo display_notice(); clear_notice(); ?>
	<div class="col-xs-12">
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
					<td><?php echo $item->id ; ?></td>
					<td><?php echo $item->firstname ; ?></td>
					<td><?php echo $item->name ; ?></td>
					<td><?php echo $item->mail ; ?></td>
					<td class="colum_action">
						<a href="#" onclick="return false" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="Envoyer un mail">
							<span data-toggle="modal" data-target=".modal_mail" data-mail="<?php echo $item->mail ; ?>" class="glyphicon glyphicon-send modal-supp-trigger"></span>
						</a>&nbsp;&nbsp;
						<a href="index.php?module=admin_users&display=fiche" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="Consulter la fiche">
							<span class="glyphicon glyphicon-list"></span>
						</a>&nbsp;&nbsp;
						<a href="index.php?module=admin_users&display=form&id=<?php echo $item->id ; ?>" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="Modifier">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="Supprimer">
							<span data-toggle="modal" data-target=".bs-example-modal-sm" data-href="index.php?module=admin_users&action=delete&id=<?php echo $item->id ; ?>" class="glyphicon glyphicon-trash modal-supp-trigger"></span>
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
<?php include_once(_APP_PATH . 'views/includes_admin/modal_mail.inc.php') ?>
