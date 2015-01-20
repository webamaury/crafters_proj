<?php
class indexController extends CoreControlers {
		
	function __construct($array_tools, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}
		$this->nb_by_page = 8;

		$this->$method($array_tools, $notices) ;

	}

	function main($array_tools, $notices) {

		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new classProducts();
		include_once(_APP_PATH . 'models/class.users.php'); $ClassUser = new classUsers();

		//CRAFTERS OF THE MONTH
		$crafter_of_month = $ClassUser->get_crafters_of_month();
		$ClassUser->user_id_product = $crafter_of_month->user_id;
		$ClassUser->limit_month_img = 6;
		$user_month_products = $ClassUser->get_product_of_user();

		//POPULAR CRAFTERS
		$popular_crafters = $ClassUser->get_popular_crafters();
		foreach($popular_crafters as $popular_crafter) {
			$ClassUser->user_id_product = $popular_crafter->user_id_product;
			$popular_crafter->creas = $ClassUser->get_product_of_user();
		}
		
		//PRODUITS DE LA LISTE PRINCIPALE
		$ClassProduct->limit = '0,'.$this->nb_by_page;
		$products = $ClassProduct->get_list_front();
		foreach($products as $product) {
			$ClassProduct->product_id = $product->product_id;
			$nb_like = $ClassProduct->number_of_like();
			$product->nb_like = $nb_like->nb_like;
			if($product->nb_like > 0){
				$product->name_likes = $ClassProduct->get_users_who_liked();
				var_dump($product->name_likes);
				if(isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] == true) {
					$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];
					$product->did_i_like = $ClassProduct->did_i_like();
				}
			}
		}
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$tools_to_load = array('bootstrap-css', 'font-awesome');
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Accueil");
		DEFINE("_METADESCRIPTION", "Accueil");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/index/display.php');
	}
	function ajax_more($array_tools, $notices) {
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new classProducts();
		$min = ($_POST['page'] - 1) * $this->nb_by_page ;
		$ClassProduct->limit = $min.','.$this->nb_by_page;
		//echo $ClassProduct->limit;exit();
		$products = $ClassProduct->get_list_front();
		if(!empty($products)){
			foreach($products as $product) {
				$ClassProduct->product_id = $product->product_id;
				$nb_like = $ClassProduct->number_of_like();
				$product->nb_like = $nb_like->nb_like;
				if(isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] == true) {
					$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];
					$product->did_i_like = $ClassProduct->did_i_like();
				}
				else {
					$product->did_i_like = 2;
				}

			}

			$json = json_encode($products);			
			echo $json; exit();
		}
		else {
			echo 'no more';
		}
	}
	function ajax_like_product() {
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new classProducts();

		$ClassProduct->product_id = $_POST['product'];
		$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];
		
		if($ClassProduct->did_i_like() == false) {
		
			if($ClassProduct->like_product()) {
				echo true;
			}
			else {
				echo false;
			}
		}
		else {
			echo 2;
		}
	}
	function ajax_unlike_product() {
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new classProducts();

		$ClassProduct->product_id = $_POST['product'];
		$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];
				
		if($ClassProduct->unlike_product()) {
			echo true;
		}
		else {
			echo false;
		}
	}

}

?>