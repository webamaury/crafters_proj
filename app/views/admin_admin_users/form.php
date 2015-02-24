<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_user">
	<?php //if(isset($item)) var_dump("<pre>",$item,"</pre>"); ?>
	<div class="col-xs-12">
		<h1 class="pull-left">Admin user</h1>
		<a href="index.php?module=adminUsers" class="btn btn-primary pull-right margin-top-20">Back to list</a>
	</div>
	
	
	<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
	<div class="col-xs-12">
		<div class="alert alert-dismissible" id="ajax_alert" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<span class="ajax_alert_content"></span>
		</div>
	</div>



	<form class="form-horizontal" method="post" enctype="multipart/form-data" class="form_upload_ajax" id="js-upload-form" action="index.php?module=adminUsers&action=uploadAjax&product=<?php echo (isset($_GET['id'])) ? '&id='.$_GET['id'] : '' ; ?>" role="form">
		<div class="col-xs-12 col-md-6 margin-top-20 text-center">
			<div class="col-xs-12"  id="img_output">
				<div id="output"><img class="img_avatar img-responsive img-circle center-block" src="<?php echo (isset($item->id) && file_exists(_ADMIN_PATH . 'img/photo_' . $item->id . '.jpg')) ? _ADMIN_PATH . 'img/photo_' . $item->id . '.jpg' : _ADMIN_PATH . 'img/avatar.jpg' ; ?>" alt="avatar"/></div>
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
					<input type="file" class="center-block" name="image_file" id="js-upload-files"/><br>
					<input type="submit" class="ajax_img_trigger btn btn-info" value="Upload">
					<input type="hidden" name="action" value="uploadAjax"/>

					<p class="help-block">( dimensions conseillées : 200 * 200 pixels )</p>
				</div>
			</div>
		</div>
	</form>
	<form class="form-horizontal" method="post" enctype="multipart/form-data" action="index.php?module=adminUsers&action=form<?php echo (isset($_GET['id'])) ? '&id='.$_GET['id'] : '' ; ?>" role="form">

		<div class="col-xs-12 col-md-6 margin-top-20">
			<div class="form-group">
				<label for="firstname" class="col-md-2 control-label">Firstname</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo (isset($item->firstname)) ? $item->firstname : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-md-2 control-label">Name</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="name" class="form-control" id="name" value="<?php echo (isset($item->name)) ? $item->name : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="mail" class="col-md-2 control-label">E-Mail</label>
				<div class="col-lg-10 col-md-8">
					<input type="email" required name="mail" class="form-control" id="mail" value="<?php echo (isset($item->mail)) ? $item->mail : '' ; ?>">
				</div>
			</div>
			<?php if(!isset($item)){ ?>
			<div class="form-group">
				<label for="password" class="col-md-2 control-label">Password</label>
				<div class="col-lg-10 col-md-8">
					<input type="password" required name="password" required class="form-control" id="password" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="password_confirm" class="col-md-2 control-label">Confirm</label>
				<div class="col-lg-10 col-md-8">
					<input type="password" required name="password_confirm" required class="form-control" id="password_confirm" value="">
				</div>
			</div>

			<?php } ?>
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Phone</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="phone" class="form-control" id="phone" value="<?php echo (isset($item->phone)) ? $item->phone : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="statut" class="col-md-2 control-label">Statut</label>
				<div class="col-lg-10 col-md-8">
					<?php if(($_SESSION['ADMIN-USER']['statut'] == 1 && isset($item->statut) && $item->statut != 1) || (!isset($item->statut))){ ?>
					<select name="statut" class="form-control">
						<?php
						foreach($statuts as $statut) {
							if($statut->statut != 1) {
							?>
						<option <?php echo (isset($item->statut) && $statut->statut == $item->statut) ? 'selected' : '' ; ?> value="<?php echo $statut->statut ; ?>"><?php echo $statut->nom ; ?></option>
							<?php
							}
						}
						?>
					</select>
					<?php 
					}
					else {
						?>
						<p class="form-control-static"><?php echo (isset($item->nom)) ? $item->nom : '' ; ?></p>
						<?php 
					}			
					if(!(($_SESSION['ADMIN-USER']['statut'] == 1 && isset($item->statut) && $item->statut != 1) || (!isset($item->statut)))){
						?>
						<input type="hidden" name="statut" value="<?php echo $item->statut ; ?>">
						<?php
					}
 					?>
				</div>
			</div>

		</div>
		<div class="col-xs-12 margin-top-20">
				<input type="hidden" name="action" value="<?php echo (isset($_GET['id'])) ? 'modifier' : 'ajouter' ; ?>">
				
				<button type="submit" class="btn btn-primary"><?php echo (isset($_GET['id'])) ? 'Update Admin' : '<span class="glyphicon glyphicon-plus font-09em"></span> Add new' ; ?></button>
				<?php if(isset($item) && $_SESSION['ADMIN-USER']['id'] == $item->id){ ?>
					<button onclick="return false" data-toggle="modal" data-target=".modal-update-password" class="btn btn-primary pull-right">Update password</button>
				<?php } ?>
		</div>
	</form>

</div>
<script type="text/javascript" src="../tools/plugin_jquery/jquery.form.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {


		var options = {
			target: '#output',   // target element(s) to be updated with server response
			beforeSubmit: beforeSubmit,  // pre-submit callback
			success: afterSuccess,  // post-submit callback
			resetForm: true        // reset the form after successful submit
		};

		$('#js-upload-form').submit(function(e) {
			e.preventDefault();
			$(this).ajaxSubmit(options);
			// always return false to prevent standard browser submit and page navigation
			return false;
		});
	});

	function afterSuccess()
	{
		$('#js-upload-submit').show(); //hide submit button
		$('#loading-img').hide(); //hide submit button
		var img_url = $('#img_output').attr('src'); //input type hidden img url
		$('#img_url').val(img_url);
	}

	//function to check file size before uploading.
	function beforeSubmit(){
		//check whether browser fully supports all File API
		if (window.File && window.FileReader && window.FileList && window.Blob)
		{

			if( !$('#js-upload-files').val()) //check empty input filed
			{
				$("#output").html("Are you kidding me?");
				return false
			}

			var fsize = $('#js-upload-files')[0].files[0].size; //get file size
			var ftype = $('#js-upload-files')[0].files[0].type; // get file type


			//allow only valid image file types
			switch(ftype)
			{
				case 'image/png': case 'image/jpeg': case 'image/pjpeg':
				break;
				default:
					$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
					return false
			}

			//Allowed file size is less than 1 MB (1048576)
			if(fsize>1048576)
			{
				$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
				return false
			}

			$('#js-upload-submit').hide(); //hide submit button
			$('#loading-img').show(); //hide submit button
			$("#output").html("");
		}
		else
		{
			//Output error to older browsers that do not support HTML5 File API
			$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
			return false;
		}
	}

	//function to format bites bit.ly/19yoIPO
	function bytesToSize(bytes) {
		var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
		if (bytes == 0) return '0 Bytes';
		var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}

</script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#ajax_alert").hide();
		$("#form_ajax_update_password").on("submit", function(e){
			//on désavtive le comportement par default
			e.preventDefault();
			//création de la requete ajax
			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=adminUsers',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: $(this).serialize(),
				//Traitement en cas de succes
				success: function(data) {
					$(".modal").modal("hide");
					if(data == true) {
						$("#ajax_alert").attr("class", "alert alert-success alert-dismissible");
						$(".ajax_alert_content").text("Password update successfully");
						$("#ajax_alert").show();
					}
					else if(data == 'error_sql'){
						$("#ajax_alert").attr("class", "alert alert-danger alert-dismissible");
						$(".ajax_alert_content").text("Error while changing password. Try later !");
						$("#ajax_alert").show();
					}
					else if(data == 'wrong_current') {
						$("#ajax_alert").attr("class", "alert alert-danger alert-dismissible");
						$(".ajax_alert_content").text("Wrong current password !");
						$("#ajax_alert").show();
					}
					else if(data == 'wrong_confirm') {
						$("#ajax_alert").attr("class", "alert alert-danger alert-dismissible");
						$(".ajax_alert_content").text("Confirmation password is different !");
					}
					else if(data == 'modif_impo') {
						$("#ajax_alert").attr("class", "alert alert-danger alert-dismissible");
						$(".ajax_alert_content").text("Impossible modification !");
					}
					$("#ajax_alert").show();
					setTimeout(function(){
						$("#ajax_alert").hide();
					}, 7000);				

				},
				error: function() {
					alert("error");
				}
			});
		});
	});
</script>

<?php		
	if(isset($item->id) && file_exists(_ADMIN_PATH . 'img/photo_' . $item->id . '.jpg')){	
?>	
<script type="text/javascript">
	$(document).ready(function(){
		
		$(".ajax-delete-trigger").on("click", function(){
			$(".ajax-delete-loader").html("<img src='img/ajax-loader.gif' alt='loader'/>");

			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=adminUsers',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: 'action=ajax_delete_avatar&id=<?php echo $_GET['id']; ?>',
				//on precise le type de flux
				//Traitement en cas de succes
				success: function(data) {
					if(data == true) {
						setTimeout(function(){
							$(".ajax-delete-loader").html(" ");
							$(".img_avatar").attr("src", "<?php echo _ADMIN_PATH ; ?>img/avatar.jpg");
							$(".ajax-delete-info").text("Image successfully deleted !");
						}, 1500);
					}
					else {
						$(".ajax-delete-info").text("Error ! Try later !");
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus + " " + errorThrown);
					console.log("Erreur execution requete ajax");
				}
			});
			
		});
	});
</script>
<?php 
	}
	if(isset($item) && $_SESSION['ADMIN-USER']['id'] == $item->id){
		include_once(_APP_PATH . 'views/includes_admin/modal_password.inc.php') ;
	}
?>
