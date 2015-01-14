<?php
	
	class productsController {
		
		function __construct($array_tools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.product.php';
			$products = new classProducts();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$messages->message_id = $_GET['id'];
				if($messages->delete_message()) {
					$notices->create_notice('success', 'Message deleted');
					header('location:index.php?module=products');exit();
				}
				else {
					$notices->create_notice('danger', 'Impossible to delete !');
					header('location:index.php?module=products');exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$messages->message_id = $_GET['id'];
					$item = $messages->get_one();
					//var_dump($item); exit();
					if(empty($item)) {
						$notices->create_notice('danger', 'Unknown message !');
						header('location:index.php?module=products');exit();
					}
					$statuts = $messages->get_statuts();

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