<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
	<h1 class="pull-left">Message</h1>
	</div>

	<?php echo display_notice(); clear_notice(); ?>
	<div class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>E-mail</th>
					<th>Title</th>
					<th>Message</th>
					<th class="colum_action">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($items as $item) {
					?>
				<tr>
					<td><?php echo $item->message_id ; ?></td>
					<td><?php echo $item->message_firstname ; ?></td>
					<td><?php echo $item->message_mail ; ?></td>
					<td><?php echo $item->message_title ; ?></td>
					<td><?php echo substr($item->message_message, 0,60) ; ?></td>
					<td class="colum_action">
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="see details">
							<span data-toggle="modal" data-target=".modal_fiche_message" data-id="<?php echo $item->message_id ; ?>" class="glyphicon glyphicon-eye-open modal-fiche-message-trigger"></span>
						</a>&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="delete">
							<span data-toggle="modal" data-target=".bs-example-modal-sm" data-href="index.php?module=messages&amp;action=delete&amp;id=<?php echo $item->message_id ; ?>" class="glyphicon glyphicon-trash modal-supp-trigger"></span>
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

	function traiterFlux(flux) {
		var obj = jQuery.parseJSON( flux );
		
		$(".ajax_creation").text(obj.message_creation);
		$(".ajax_firstname").text(obj.message_firstname);
		$(".ajax_name").text(obj.message_name);
		$(".ajax_mail").text(obj.message_mail);
		$(".ajax_title").text(obj.message_title);
		$(".ajax_message").text(obj.message_message);

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
		$(".modal-fiche-message-trigger").on("click", function(){
			var item_id = $(this).attr("data-id");
			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=messages',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: 'action=ajax_display_message_fiche&id=' + item_id,
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
<?php include_once(_APP_PATH . 'views/includes_admin/modal_fiche_message.inc.php') ?>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_supp.inc.php') ?>
