<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
	<h1 class="pull-left">Users</h1>
	</div>

	<?php echo display_notice(); clear_notice(); ?>
	<div class="col-xs-12 table-responsive">
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
					<td><?php echo $item->user_id ; ?></td>
					<td><?php echo $item->user_firstname ; ?></td>
					<td><?php echo $item->user_name ; ?></td>
					<td><?php echo $item->user_mail ; ?></td>
					<td class="colum_action">
						<!--
<a href="#" onclick="return false" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="send a mail">
							<span data-toggle="modal" data-target=".modal_mail" data-mail="<?php echo $item->user_mail ; ?>" class="glyphicon glyphicon-send modal-supp-trigger"></span>
						</a>&nbsp;&nbsp;
-->
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="see details">
							<span data-toggle="modal" data-target=".modal_fiche_user" data-id="<?php echo $item->user_id ; ?>" class="glyphicon glyphicon-eye-open modal-fiche-trigger"></span>
						</a>&nbsp;&nbsp;
						<a href="index.php?module=users&amp;action=form&amp;id=<?php echo $item->user_id ; ?>" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="update">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="delete">
							<span data-toggle="modal" data-target=".bs-example-modal-sm" data-href="index.php?module=users&amp;action=delete&amp;id=<?php echo $item->user_id ; ?>" class="glyphicon glyphicon-trash modal-supp-trigger"></span>
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
<script type="text/javascript">

	function ImageExist(url_img) 
	{
		var myreturn ;
		$.ajax({
			url: url_img, //or your url
			success: function(){
				$(".ajax_img").attr("src", url_img);
			},
			error: function(){
				$(".ajax_img").attr("src", '<?php echo _ADMIN_PATH; ?>img/avatar.jpg');		
			},
		});
	}
	
	function traiterFlux(flux) {
		var obj = jQuery.parseJSON( flux );
		var img_url = '<?php echo _ADMIN_PATH; ?>img/photo_' + obj.id + '.jpg';
		ImageExist(img_url);
		
		$(".ajax_firstname").text(obj.user_firstname);
		$(".ajax_name").text(obj.user_name);
		$(".ajax_mail").text(obj.user_mail);
		$(".ajax_phone").text(obj.user_phone);
		$(".ajax_birthday").text(obj.user_birthday);
		$(".ajax_creation").text(obj.user_creation);
		$(".ajax_status").text(obj.nom);

		//alert( obj.name );
		//var obj = jQuery.parseJSON(flux);
		//alert(obj.name);
		/*$.each(flux, function(key,value) {
			if(key == 'name') {
			$('.ajax_name').text(value);
			}
			//contenu += "<li>Key : "+key+" - Value : "+value+"</li>";
		});*/
		//$(affichage).html(contenu);

	}

	
	
	$(document).ready(function(){
		$('.table').DataTable();
		$(".modal-fiche-trigger").on("click", function(){
			var item_id = $(this).attr("data-id");
			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=users',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: 'action=ajax_display_user_fiche&id=' + item_id,
				//on precise le type de flux
				//Traitement en cas de succes
				success: function(data) {
					console.log("flux : " + data);
					traiterFlux(data);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus + " " + errorThrown);
					console.log("Erreur execution requete ajax");
				}
			});
			
		});
	});
</script>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_supp.inc.php') ?>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_mail.inc.php') ?>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_fiche_user.inc.php') ?>
