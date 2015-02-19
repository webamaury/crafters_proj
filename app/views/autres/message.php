<?php include("../app/views/includes/head.inc.php") ; ?>


<?php include("../app/views/includes/header.inc.php"); ?>

	<div class="container messagepage">
		<div class="col-md-8 col-xs-12 col-md-offset-2 text-center">
			<div class="col-xs-12 messagepageicon"><?php echo $icon; ?></div>
			<div class="col-xs-12 messagepageheader"><?php echo $header; ?></div>
			<div class="col-xs-12 messagepagecontent"><?php echo $content; ?></div>
		</div>
	</div>

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>