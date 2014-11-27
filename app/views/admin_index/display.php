<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_index">
	<div class="col-xs-12 col-md-10 modules_button">
		<div class="col-md-12">
			<div class="col-md-12 thumbnail" style="height:150px;">
				<h2>Stats</h2>
			</div>
		</div>
		<?php
		foreach ($modules as $module)
		{
			?>
		<div class="col-xs-6 col-md-3">
			<a href="index.php?module=<?php echo $module['path'] ; ?>">
				<div class="thumbnail text-center">
					<span class="glyphicon <?php echo $module['icon'] ; ?>"></span>
					<br/><h3><?php echo $module['name'] ; ?></h3>
					<p><?php echo $module['description'] ; ?></p>
				</div>
			</a>
		</div>
			<?php
		}
		?>
	</div>
	<div class="col-xs-12 col-md-2 thumbnail" style="height:500px;"></div>
</div>