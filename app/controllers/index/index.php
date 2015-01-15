<?php
class indexController extends CoreControlers {
	
	function __construct($array_tools, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($array_tools, $notices) ;

	}

	function main($array_tools, $notices) {

		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new classProducts();
		$ClassProduct->limit = '0,12';
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
		$nb_by_page = 12;
		$min = ($_POST['page'] - 1) * $nb_by_page ;
		$ClassProduct->limit = $min.','.$nb_by_page;
		//echo $ClassProduct->limit;exit();
		$products = $ClassProduct->get_list_front();
		if(!empty($products)){
			$json = json_encode($products);			
			echo $json; exit();
		}
		else {
			echo 'no more';
		}
	}
}

?>