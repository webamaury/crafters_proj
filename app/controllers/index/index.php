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

		$crafter_of_month = $ClassUser->get_crafters_of_month();
		$ClassUser->user_id_product = $crafter_of_month->user_id;
		$ClassUser->limit_month_img = 4;
		$user_month_products = $ClassUser->get_product_of_user();
		$ClassProduct->limit = '0,'.$this->nb_by_page;
		$products = $ClassProduct->get_list_front();
		foreach($products as $product) {
			$ClassProduct->product_id = $product->product_id;
			$nb_like = $ClassProduct->number_of_like();
			$product->nb_like = $nb_like->nb_like;
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
		
		if($ClassProduct->like_product()) {
			echo true;
		}
		else {
			echo false;
		}
	}
}

?>