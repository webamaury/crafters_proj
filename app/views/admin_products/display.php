<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_users">
	<div class="col-xs-12">
	<h1 class="pull-left">Product</h1>
	<a href="index.php?module=products&amp;action=form" class="btn btn-primary pull-right margin-top-20"><span class="glyphicon glyphicon-plus font-09em"></span> Add new</a>
	</div>

	<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
	<div class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th class="table_img">#</th>
					<th>Name</th>
					<th>Status</th>
					<th class="colum_action">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($items as $item) {
					?>
				<tr <?php echo ($item->status_name == 'public disable') ? 'class="warning"' : '' ; ?>>
					<td><img src="../<?php echo $item->product_img_url ; ?>" alt="product image" width="30" height="30"></td>
					<td><?php echo $item->product_name ; ?></td>
					<td><?php echo $item->status_name ; ?></td>
					<td class="colum_action">
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="see details">
							<span data-toggle="modal" data-target=".modal_fiche_product" data-id="<?php echo $item->product_id ; ?>" class="glyphicon glyphicon-eye-open modal-fiche-product-trigger"></span>
						</a>&nbsp;&nbsp;
						<a href="index.php?module=products&amp;action=form&amp;id=<?php echo $item->product_id ; ?>" class="tips-trigger" data-toggle="tooltip" data-placement="bottom" title="update">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>&nbsp;
						<a href="#" onclick="return false" class="tips-trigger"  data-toggle="tooltip" data-placement="bottom" title="delete">
							<span data-toggle="modal" data-target=".bs-example-modal-sm" data-href="index.php?module=products&amp;action=delete&amp;id=<?php echo $item->product_id ; ?>" class="glyphicon glyphicon-trash modal-supp-trigger"></span>
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
		var img_url = '<?php echo _WWW_PATH; ?>' + obj.product_img_url;
		ImageExist(img_url);
		
		$(".ajax_name").text(obj.product_name);
		$(".ajax_description").text(obj.product_description);
		$(".ajax_creation").text(obj.DateCrea);
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
	});
	$(document).on("click", ".modal-fiche-product-trigger", function(){
			var item_id = $(this).attr("data-id");
			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=products',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: 'action=ajax_display_product_fiche&id=' + item_id,
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
<?php include_once(_APP_PATH . 'views/includes_admin/modal_fiche_product.inc.php') ?>
<?php include_once(_APP_PATH . 'views/includes_admin/modal_supp.inc.php') ?>
