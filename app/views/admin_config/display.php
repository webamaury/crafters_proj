<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_index">
	<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>

<form class="form-horizontal" action="index.php?module=config&action=modifFile" method="post">

	<div class="col-xs-12 margin-top-20">
		<h4>Config</h4>
		<div class="checkbox">
			<label>
				<input type="checkbox" value="true" name="rewurl"<?php echo (isset($config->rewurl) && $config->rewurl == "true") ? " checked" : ""; ?>>
				Activate Url rewriting
			</label>
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" value="true" name="standby"<?php echo (isset($config->standby) && $config->standby == "true") ? " checked" : ""; ?>>
				Put whole website disable with a standby page
			</label>
		</div>
		<br/><br/>
		<button type="submit" class="btn btn-primary">Valid</button>
	</div>

</form>

</div>
