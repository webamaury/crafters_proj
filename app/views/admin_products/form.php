<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_user">
	<?php //if(isset($item)) var_dump("<pre>",$item,"</pre>"); ?>
	<div class="col-xs-12">
		<h1 class="pull-left">Message</h1>
		<a href="index.php?module=messages" class="btn btn-primary pull-right margin-top-20">Back to list</a>
	</div>
	
	<?php echo $notices->display_notice(); $notices->clear_notice(); ?>
	<form class="form-horizontal" method="post" enctype="multipart/form-data" action="index.php?module=messages&action=form<?php echo (isset($_GET['message_id'])) ? '&id='.$_GET['message_id'] : '' ; ?>" role="form">
		<!--<div class="col-xs-12 col-md-6 margin-top-20 text-center">
			<div class="col-xs-12">
				<img class="img_avatar" src="<?php echo (isset($item->id) && file_exists(_ADMIN_PATH . 'img/photo_' . $item->id . '.jpg')) ? _ADMIN_PATH . 'img/photo_' . $item->id . '.jpg' : _ADMIN_PATH . 'img/avatar.jpg' ; ?>" alt="avatar"/>
				<?php
					if(isset($item->id) && file_exists(_ADMIN_PATH . 'img/photo_' . $item->id . '.jpg')){
				?>
				<div class="col-xs-12 ajax-delete-info">
					<a href="#" class="ajax-delete-trigger">Delete image<span class="ajax-delete-loader"></span></a>
				</div>
				<?php
					}
				?>
				<div class="form-group margin-top-20">
				    <label for="exampleInputFile">Image</label>
				    <input class="center-block" type="file" id="exampleInputFile">
				    <p class="help-block">( dimensions conseillées : 200 * 200 pixels )</p>
				  </div>
			</div>
		</div>-->
		<div class="col-xs-12 col-md-6 margin-top-20">
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Creation</label>
				<div class="col-lg-10 col-md-8">
					<p class="form-control-static"><?php echo (isset($item->message_creation)) ? $item->message_creation : '' ; ?></p>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-md-2 control-label">Firstname</label>
				<div class="col-lg-10 col-md-8">
					<p class="form-control-static"><?php echo (isset($item->message_firstname)) ? $item->message_firstname : '' ; ?></p>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-md-2 control-label">Name</label>
				<div class="col-lg-10 col-md-8">
					<p class="form-control-static"><?php echo (isset($item->message_name)) ? $item->message_name : '' ; ?></p>
				</div>
			</div>
			<div class="form-group">
				<label for="mail" class="col-md-2 control-label">E-Mail</label>
				<div class="col-lg-10 col-md-8">
					<p class="form-control-static"><?php echo (isset($item->message_mail)) ? $item->message_mail : '' ; ?></p>
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Title</label>
				<div class="col-lg-10 col-md-8">
					<p class="form-control-static"><?php echo (isset($item->message_title)) ? $item->message_title : '' ; ?></p>
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Message</label>
				<div class="col-lg-10 col-md-8">
					<p class="form-control-static"><?php echo (isset($item->message_message)) ? $item->message_message : '' ; ?></p>
				</div>
			</div>

		</div>
	</form>

</div>
