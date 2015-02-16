<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
	<h1 class="pull-left">Message</h1>
	</div>

	<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
	<div class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>E-mail</th>
					<th>Date</th>
					<th>Status</th>
					<th class="colum_action">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($items as $item) {
					?>
				<tr id="tr_<?php echo (isset($item->message_id)) ? $item->message_id : "" ; ?>" <?php echo ($item->status_name == 'unread') ? 'class="warning"' : '' ; ?>>
					<td><?php echo (isset($item->message_id)) ? $item->message_id : "" ; ?></td>
					<td><?php echo (isset($item->message_mail)) ? $item->message_mail : "" ; ?></td>
					<td><?php echo (isset($item->message_creation)) ? $item->message_creation : "" ; ?></td>
					<td class="changeStatus"><?php echo (isset($item->status_name)) ? $item->status_name : "" ; ?></td>
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
	function nl2br (str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
	}

	function traiterFlux(flux, trigger) {
		var obj = jQuery.parseJSON( flux );


		
		$(".ajax_creation").text(obj.DateCrea);
		$(".ajax_firstname").text(obj.message_firstname);
		$(".ajax_name").text(obj.message_name);
		$(".ajax_mail").text(obj.message_mail);
		$(".ajax_message").html(nl2br(obj.message_message));
		$(".ajax_status").text(obj.nom);

		if (obj.read == true) {
			$('#tr_'+obj.message_id).removeClass('warning');
			$('#tr_'+obj.message_id).children('.changeStatus').text('read');
		}

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
			var trigger = $(this);
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
					traiterFlux(data, trigger);
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
