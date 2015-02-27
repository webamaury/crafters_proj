<?php
class ficheController extends CoreController {
		
	function __construct($arrayCss, $arrayJs, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($arrayCss, $arrayJs, $notices) ;

	}

	function main($arrayCss, $arrayJs, $notices) {

		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new ClassProducts();
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();

		if (!isset($_GET['product']) || empty($_GET['product'])) {
			header('location:index.php');
		}

		$ClassProduct->product_id = $_GET['product'];
		$craft = $ClassProduct->get0ne();
		if (empty($craft)) {
			header('location:index.php');
		}
		if ($craft->product_status == 0 || $craft->product_status == 1) {
			if (!isset($_SESSION[_SES_NAME]['id']) || $craft->user_id_product != $_SESSION[_SES_NAME]['id']) {
				header('location:index.php');
			}
		}
		$ClassProduct->product_id = $craft->product_id;
		$nb_like = $ClassProduct->numberOfLike();
		$craft->nb_like = $nb_like->nb_like;
		if ($craft->nb_like > 0) {
			$craft->name_likes = $ClassProduct->getUsersWhoLiked();
			if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] === true) {
				$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];
				$craft->did_i_like = $ClassProduct->didILike();
			}
		}


		$ClassUser->user_id = $craft->user_id_product;
		$crafter = $ClassUser->getOne();

		$products = $ClassUser->getProductOfUser('5', $craft->user_id_product);
		foreach ($products as $product) {
			$ClassProduct->product_id = $product->product_id;
			$nb_like = $ClassProduct->numberOfLike();
			$product->nb_like = $nb_like->nb_like;
			if ($product->nb_like > 0) {
				$product->name_likes = $ClassProduct->getUsersWhoLiked();
				if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] === true) {
					$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];
					$product->did_i_like = $ClassProduct->didILike();
				}
			}
		}
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'loadmore.js', 'panier.js');

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Accueil");
		DEFINE("_METADESCRIPTION", "Accueil");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/fiche/display.php');
	}
}

?>