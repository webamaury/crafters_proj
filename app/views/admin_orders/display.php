<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_orders">
	<div class="col-xs-12">
	<h1 class="pull-left">Orders</h1>
	</div>

	<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
	<div class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>Status</th>
					<th>Creation</th>
					<th>NbProduit</th>
					<th class="colum_action">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($items as $item) {
					?>
				<tr>
					<td><?php echo $item->order_id ; ?></td>
					<td><?php echo $item->user_username ; ?></td>
					<td><?php echo $item->order_status ; ?></td>
					<td><?php echo $item->DateCrea ; ?></td>
					<td><?php echo $item->nbProduit ; ?></td>
					<td class="colum_action">
						<!--
<a href="#" onclick="return false" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="send a mail">
							<span data-toggle="modal" data-target=".modal_mail" data-mail="<?php echo $item->user_mail ; ?>" class="glyphicon glyphicon-send modal-supp-trigger"></span>
						</a>&nbsp;&nbsp;
-->
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="see details">
							<span data-toggle="modal" data-target=".modal_fiche_order" data-id="<?php echo $item->order_id ; ?>" class="glyphicon glyphicon-eye-open modal-fiche-trigger"></span>
						</a>&nbsp;&nbsp;
						<a href="index.php?module=users&amp;action=form&amp;id=<?php echo $item->order_id ; ?>" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="update">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="delete">
							<span data-toggle="modal" data-target=".bs-example-modal-sm" data-href="index.php?module=orders&amp;action=delete&amp;id=<?php echo $item->order_id ; ?>" class="glyphicon glyphicon-trash modal-supp-trigger"></span>
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
			}
		});
	}
	
	function traiterFlux(flux) {
		var obj = jQuery.parseJSON( flux );
		var img_url = '<?php echo _WWW_PATH; ?>' + obj.user_img_url;
		ImageExist(img_url);
		
		$(".ajax_datecrea").text(obj.DateCrea);
		$(".ajax_status").text(obj.order_status);
		$(".ajax_nbproduit").text(obj.nbProduit);
		$(".ajax_name").text(obj.user_name);
		$(".ajax_firstname").text(obj.user_firstname);
		$(".ajax_numberstreet").text(obj.address_numberstreet);
		$(".ajax_town").text(obj.address_town);
		$(".ajax_zipcode").text(obj.address_zipcode);
		$(".ajax_country").text(obj.address_country);

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


		var html = " ";
		for (var key in obj.product) {

			html += '<tr>';
			html += '<td>' + obj.product[key].product_id + '</td>';
			html += '<td>' + obj.product[key].product_order_type + '</td>';
			html += '<td>' + obj.product[key].product_order_quantity + '</td>';
			html += '<td>' + obj.product[key].product_name + '</td>';
			html += '<td>' + obj.product[key].product_order_size + '</td>';
			html += '</tr>';

		}
		$('.product_order').html(html);

	}

	$(document).ready(function () {
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
		$("#load_more").on("click", function (e) {
			e.preventDefault();
			$(this).append('<img id="ajax_loader" src="img/ajax-loader.gif" alt="ajax loader"/>');
			var page = $(this).attr("data-num");
			page++;
			$(this).attr("data-num", page);
			$.ajax({
				// URL du traitement sur le serveur
				url: 'index.php?module=index',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: 'action=ajax_more&page=' + page,
				//on precise le type de flux
				//Traitement en cas de succes
				success: function (data) {
					if (data == 'no more') {
						$('#load_more').html('no more product');
					}
					else {
						traiterFlux(data);
					}
					$('#ajax_loader').remove();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(textStatus + " " + errorThrown);
					console.log("Erreur execution requete ajax");
				}
			});
		});
	});
	
	$(document).ready(function(){
		$('.table').DataTable({
			"order": [[2, "asc"]]
		});
		$('.table_modal').DataTable({
			"paging": false,
			"searching": false,
			"info": false,
			"ordering": false
		});
		$(".modal-fiche-trigger").on("click", function(){
			var item_id = $(this).attr("data-id");
			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=orders',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: 'action=ajax_display_order_fiche&id=' + item_id,
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
<?php include_once(_APP_PATH . 'views/includes_admin/modal_fiche_order.inc.php') ?>
