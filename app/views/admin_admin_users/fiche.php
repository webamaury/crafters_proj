<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_user">
	<?php //if(isset($item)) var_dump("<pre>",$item,"</pre>"); ?>
	<div class="col-xs-12">
		<h1 class="pull-left">Admin user</h1>
		<a href="index.php?module=admin_users" class="btn btn-primary pull-right margin-top-20">Retour liste</a>
	</div>
	<div class="col-xs-12 margin-top-20">
		<?php echo display_notice(); clear_notice(); ?>
		<form class="form-horizontal" method="post" action="<?php echo $current_page ; ?>" role="form">
			<div class="form-group">
				<label for="firstname" class="col-md-2 control-label">Prénom</label>
				<div class="col-lg-4 col-md-8">
					<input type="text" name="firstname" class="form-control" id="firstname" placeholder="Prénom" value="<?php echo (isset($item->firstname)) ? $item->firstname : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-md-2 control-label">Nom</label>
				<div class="col-lg-4 col-md-8">
					<input type="text" name="name" class="form-control" id="name" placeholder="Nom" value="<?php echo (isset($item->name)) ? $item->name : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="mail" class="col-md-2 control-label">E-Mail</label>
				<div class="col-lg-4 col-md-8">
					<input type="email" name="mail" class="form-control" id="mail" placeholder="E-Mail" value="<?php echo (isset($item->mail)) ? $item->mail : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Téléphone</label>
				<div class="col-lg-4 col-md-8">
					<input type="text" name="phone" class="form-control" id="phone" placeholder="Téléphone" value="<?php echo (isset($item->phone)) ? $item->phone : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="mail" class="col-md-2 control-label">Statut</label>
				<div class="col-lg-4 col-md-8">
					<select class="form-control">
						<?php
						foreach($statuts as $statut) {
							?>
						<option <?php echo (isset($item->statut) && $statut->statut == $item->statut) ? 'selected' : '' ; ?> value="<?php echo $statut->statut ; ?>"><?php echo $statut->nom ; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<input type="hidden" name="action" value="<?php echo (isset($_GET['id'])) ? 'modifier' : 'ajouter' ; ?>">
			<input type="submit" class="btn btn-primary" value="<?php echo (isset($_GET['id'])) ? 'Modifier' : 'Ajouter' ; ?>">

		</form>
	</div>
</div>
