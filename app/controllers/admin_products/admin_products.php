<?php
	
	class productsController {
		
		function __construct($array_tools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.product.php';
			$products = new classProducts();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$products->product_id = $_GET['id'];
				if($products->delete_product()) {
					$notices->create_notice('success', 'Message deleted');
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
				
				if($products->update_product()) {
					$notices->create_notice('success', 'User modifié');
					header('location:index.php?module=products&action=form&id='.$_GET['id']);exit();
				}
				else {
					$notices->create_notice('danger', 'erreur modif');
					header('location:index.php?module=products&action=form&id='.$_GET['id']);exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$products->product_id = $_GET['id'];
					$item = $products->get_one();
					//var_dump($item); exit();
					if(empty($item)) {
						$notices->create_notice('danger', 'Unknown message !');
						header('location:index.php?module=products');exit();
					}
					$statuts = $products->get_statuts();

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
				$items = $products->get_list();
				
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
					$ajax_item = $products->get_one_array();
					$ajax_item = json_encode($ajax_item);
					echo $ajax_item;
			}



		}
	}
?>