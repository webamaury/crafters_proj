<?php
	
	class productsController {
		
		function __construct($array_tools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.product.php';
			$products = new ClassProducts();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$products->product_id = $_GET['id'];
				if($products->deleteProduct()) {
					$notices->create_notice('success', 'Product deleted');
					header('location:index.php?module=products');exit();
				}
				else {
					$notices->create_notice('danger', 'Impossible to delete !');
					header('location:index.php?module=products');exit();
				}
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'modifier') {

				$products->product_id 				= $_GET['id'];
				$products->product_name				= $_POST['name'];
				$products->product_description 		= $_POST['description'];
				$products->product_status 			= $_POST['statut'];
				$products->product_type 			= $_POST['type'];
				
	//						echo $_POST['statut']."<br>";
	//						echo $adminUsers->statut ; exit();	
				
				if($products->updateProduct()) {
					$notices->create_notice('success', 'Product updated');
					header('location:index.php?module=products&action=form&id='.$_GET['id']);exit();
				}
				else {
					$notices->create_notice('danger', 'erreur modif');
					header('location:index.php?module=products&action=form&id='.$_GET['id']);exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$products->product_id = $_GET['id'];
					$item = $products->get0ne();
					//var_dump($item); exit();
					if(empty($item)) {
						$notices->create_notice('danger', 'Unknown message !');
						header('location:index.php?module=products');exit();
					}
					$statuts = $products->getStatuts();

				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
				$styles_to_load = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Admin product");
				DEFINE("_METADESCRIPTION", "Admin product");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_products/form.php');
			}
			else if((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] == 'list')) {
				$items = $products->getList();
				
				//$items = $adminUsers;
				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
				$styles_to_load = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Admin product");
				DEFINE("_METADESCRIPTION", "Admin product");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_products/display.php');
			}
			else if (isset($_POST['action']) && $_POST['action'] == 'ajax_display_product_fiche') {
					$products->product_id = $_POST['id'];
					$ajax_item = $products->getOneArray();
					$ajax_item = json_encode($ajax_item);
					echo $ajax_item;
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_delete_avatar') {
					if(unlink(_WWW_PATH . $_POST['img_url'])) {
						$products->product_id=$_POST["product_id"];
						if($products->deleteAddressImg()){
							echo true;
						}
					}
					else {
						echo false;
					}
			}

		}
	}
?>