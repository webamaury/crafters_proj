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
					<th>Delivery</th>
					<th>Payment Mode</th>
					<th>Price</th>
					<th>NbProduct</th>
					<th>Creation</th>
					<th class="colum_action">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($items as $item) {
					?>
				<tr<?php if ($item->nom == 'Pending payment') { echo ' class="warning"';} else if ($item->nom == 'Paid') { echo ' class="danger"';} else { echo ' class="success"';} ?>>
					<td><?php echo $item->order_id ; ?></td>
					<td><?php echo $item->user_username ; ?></td>
					<td><?php echo $item->nom ; ?></td>
					<td><?php if ($item->order_delivery == 0) {
							echo "Normal";
						} else {
							echo "Express";
						} ?>
					</td>
					<td><?php if ($item->order_payment_mode == 0) {
							echo "Paypal";
						} else {
							echo "Cheque";
						} ?>
					</td>
					<td><?php echo $item->order_price ; ?> €</td>
					<td><?php echo $item->nbProduit ; ?></td>
					<td><?php echo $item->DateCrea ; ?></td>
					<td class="colum_action">
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="see details">
							<span data-toggle="modal" data-target=".modal_fiche_order" data-id="<?php echo $item->order_id ; ?>" class="glyphicon glyphicon-eye-open modal-fiche-trigger"></span>
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
		
		$(".ajax_hash").text(obj.order_hash);
		$(".ajax_datecrea").text(obj.DateCrea);
		$(".ajax_status").text(obj.nom);
		if (obj.order_delivery == 0) {
			$(".ajax_delivery").text('Normal');
		} else {
			$(".ajax_delivery").text('Express');
		}
		if (obj.order_payment_mode == 0) {
			$(".ajax_payment_mode").text('Paypal');
		} else {
			$(".ajax_payment_mode").text('Cheque');
		}
		$(".ajax_price").text(obj.order_price +' €');
		$(".ajax_name").text(obj.user_name);
		$(".ajax_firstname").text(obj.user_firstname);

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
		for (var key in obj.address) {
			html += '<h4 class="text-center">' + obj.address[key].nom + ' address</h4>';
			html += '<form class="form-horizontal address_order" method="post" action="#" role="form">';
			html += '<div class="display-inline">';
			html += '<label class="col-md-4 control-label">Street : </label>';
			html += '<div class="col-md-8">';
			html += '<p class="form-control-static ajax_numberstreet">' + obj.address[key].address_numberstreet + '</p>';
			html += '</div>';
			html += '</div>';
			html += '<div class="display-inline">';
			html += '<label class="col-md-4 control-label">Town : </label>';
			html += '<div class="col-md-8">';
			html += '<p class="form-control-static ajax_town">' + obj.address[key].address_town + '</p>';
			html += '</div>';
			html += '</div>';
			html += '<div class="display-inline">';
			html += '<label class="col-md-4 control-label">Zipcode : </label>';
			html += '<div class="col-md-8">';
			html += '<p class="form-control-static ajax_zipcode">' + obj.address[key].address_zipcode + '</p>';
			html += '</div>';
			html += '</div>';
			html += '<div class="display-inline">';
			html += '<label class="col-md-4 control-label">Country : </label>';
			html += '<div class="col-md-8">';
			html += '<p class="form-control-static ajax_country">' + obj.address[key].address_country + '</p>';
			html += '</div>';
			html += '</div>';
			if (obj.address[key].address_name != null){
				html += '<div class="display-inline">';
				html += '<label class="col-md-4 control-label">Name : </label>';
				html += '<div class="col-md-8">';
				html += '<p class="form-control-static ajax_country">' + obj.address[key].address_name + '</p>';
				html += '</div>';
				html += '</div>';
				html += '<div class="display-inline">';
				html += '<label class="col-md-4 control-label">Firstname : </label>';
				html += '<div class="col-md-8">';
				html += '<p class="form-control-static ajax_country">' + obj.address[key].address_firstname + '</p>';
				html += '</div>';
				html += '</div>';
			}
			html += '</form>';

		}
		$('.address_order').html(html);

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

		if(obj.order_status == '1')
		{
			$('.ajax_send').html('<a class="pull-left btn btn-primary" href="index.php?module=orders&action=send&order=' + obj.order_hash + '">Send</a>');
		} else if (obj.order_status == '0') {
			$('.ajax_paid').html('<a class="pull-left btn btn-primary" href="index.php?module=orders&action=paid&order=' + obj.order_hash + '">Paid</a>');
		}


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
	});
	$(document).on("click", ".modal-fiche-trigger", function(){
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
</script>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_supp.inc.php') ?>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_mail.inc.php') ?>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_fiche_order.inc.php') ?>
