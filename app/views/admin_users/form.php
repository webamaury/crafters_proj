<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_user">
	<?php //if(isset($item)) var_dump("<pre>",$item,"</pre>"); ?>
	<div class="col-xs-12">
		<h1 class="pull-left">User</h1>
		<a href="index.php?module=users" class="btn btn-primary pull-right margin-top-20">Back to list</a>
	</div>
	
	
	
	<div class="col-xs-12">
		<div class="alert alert-dismissible" id="ajax_alert" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<span class="ajax_alert_content"></span>
		</div>
	</div>
	
	
	
	
	<form class="form-horizontal" method="post" enctype="multipart/form-data" action="index.php?module=users&action=form<?php echo (isset($_GET['id'])) ? '&id='.$_GET['id'] : '' ; ?>" role="form">
		<div class="col-xs-12 col-md-6 margin-top-20 text-center">
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
		</div>
		<div class="col-xs-12 col-md-6 margin-top-20">
			<div class="form-group">
				<label for="firstname" class="col-md-2 control-label">Firstname</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo (isset($item->user_firstname)) ? $item->user_firstname : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-md-2 control-label">Name</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="name" class="form-control" id="name" value="<?php echo (isset($item->user_name)) ? $item->user_name : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="mail" class="col-md-2 control-label">E-Mail</label>
				<div class="col-lg-10 col-md-8">
					<input type="email" required name="mail" class="form-control" id="mail" value="<?php echo (isset($item->user_mail)) ? $item->user_mail : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Phone</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="phone" class="form-control" id="phone" value="<?php echo (isset($item->user_phone)) ? $item->user_phone : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Birthday</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="birthday" class="form-control" id="birthday" value="<?php echo (isset($item->user_birthday)) ? $item->user_birthday : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-md-2 control-label">Creation</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="creation" class="form-control" id="creation" readonly value="<?php echo (isset($item->user_creation)) ? $item->user_creation : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="statut" class="col-md-2 control-label">Statut</label>
				<div class="col-lg-10 col-md-8">
					<select name="statut" class="form-control">
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

		</div>
		<div class="col-xs-12 margin-top-20">
				<input type="hidden" name="action" value="<?php echo (isset($_GET['id'])) ? 'modifier' : 'ajouter' ; ?>">
				
				<button type="submit" class="btn btn-primary"><?php echo (isset($_GET['id'])) ? 'Update Admin' : '<span class="glyphicon glyphicon-plus font-09em"></span> Add new' ; ?></button>
		</div>
	</form>

</div>
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
	if(isset($item) && $_SESSION['ADMIN-USER']['id'] == $item->user_id){
		include_once(_APP_PATH . 'views/includes_admin/modal_password.inc.php') ;
	}
?>
