<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_user">
	<?php //if(isset($item)) var_dump("<pre>",$item,"</pre>"); ?>
	<div class="col-xs-12">
		<h1 class="pull-left">User</h1>
		<a href="index.php?module=users" class="btn btn-primary pull-right margin-top-20">Back to list</a>
	</div>
	
	
	<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
	<div class="col-xs-12">
		<div class="alert alert-dismissible" id="ajax_alert" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<span class="ajax_alert_content"></span>
		</div>
	</div>
	
	
	
	<form class="form-horizontal" method="post" enctype="multipart/form-data" class="form_upload_ajax" id="js-upload-form" action="index.php?module=users&action=uploadAjax&user=<?php echo (isset($item->user_id)) ? $item->user_id : '' ; ?>" role="form">
		<div class="col-xs-12 col-md-6 margin-top-20 text-center">
			<div class="col-xs-12"  id="img_output">
				<div id="output"><img class="img_avatar img-responsive img-circle center-block" src="<?php echo (isset($item->user_img_url) && !empty($item->user_img_url) && file_exists(_WWW_PATH . $item->user_img_url)) ? _WWW_PATH . $item->user_img_url : "http://www.gravatar.com/avatar/" . md5($item->user_mail) . "?s=360" ;?>" alt="avatar"/></div>
				<?php
					if(isset($item->user_img_url) && file_exists(_WWW_PATH . $item->user_img_url)){
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
	<form class="form-horizontal" method="post" enctype="multipart/form-data" action="index.php?module=users&action=form<?php echo (isset($_GET['id'])) ? '&id='.$_GET['id'] : '' ; ?>" role="form">
		<div class="col-xs-12 col-md-6 margin-top-20">
			<div class="form-group">
				<label for="username" class="col-md-2 control-label">Username</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="username" class="form-control" id="username" value="<?php echo (isset($item->user_username)) ? $item->user_username : '' ; ?>">
				</div>
			</div>
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
				<label for="birthday" class="col-md-2 control-label">Birthday</label>
				<div class="col-lg-10 col-md-8">
					<input type="date" name="birthday" class="form-control" id="birthday" value="<?php echo (isset($item->user_birthday)) ? $item->user_birthday : '' ; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="creation" class="col-md-2 control-label">Creation</label>
				<div class="col-lg-10 col-md-8">
					<input type="text" name="creation" class="form-control" id="creation" readonly value="<?php echo (isset($item->DateCrea)) ? $item->DateCrea : '' ; ?>">
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
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="checkbox_month" value="1"<?php echo (isset($item->user_month) && $item->user_month == 1) ? " checked" : "" ; ?>> Crafter of the month
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="creation" class="col-md-2 control-label">Description</label>
				<div class="col-lg-10 col-md-8">
					<textarea class="form-control" name="descr_month" rows="3"><?php echo (isset($item->user_description)) ? $item->user_description : '' ; ?></textarea>
				</div>
			</div>
		</div>
		<div class="col-xs-12 margin-top-20">
				<input type="hidden" name="action" value="<?php echo (isset($_GET['id'])) ? 'modifier' : 'ajouter' ; ?>">
				
				<button type="submit" class="btn btn-primary"><?php echo (isset($_GET['id'])) ? 'Update User' : '<span class="glyphicon glyphicon-plus font-09em"></span> Add new' ; ?></button>
		</div>
	</form>

</div>
<script type="text/javascript" src="../tools/plugin_jquery/jquery.form.min.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
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
	});
</script>

<?php		
	if(isset($item->user_img_url) && file_exists(_WWW_PATH . $item->user_img_url)){	
?>	
<script type="text/javascript">
	$(document).ready(function(){
		
		$(".ajax-delete-trigger").on("click", function(){
			$(".ajax-delete-loader").html("<img src='img/ajax-loader.gif' alt='loader'/>");

			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=users',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: 'action=ajax_delete_avatar&img_url=<?php echo $item->user_img_url; ?>&user_id=<?php echo $item->user_id; ?>',
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
?>
