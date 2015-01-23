<?php

/**
 * Class IndexController
 */
class IndexController extends CoreControlers
{

	/**
	 * @param $arrayTools
	 * @param $notices
	 */
	function __construct($arrayTools, $notices)
	{

		if (!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main';
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		}
		$this->nb_by_page = 12;
		var_dump($_SESSION);

		$this->$method($arrayTools, $notices);
	}

	/**
	 * @param $arrayTools
	 * @param $notices
	 */
	function main($arrayTools, $notices)
	{
		/*************************************************************
		 * 	TRAITEMENT PHP											**
		 * **********************************************************/
		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();
		include_once(_APP_PATH . 'models/class.users.php');
		$ClassUser = new ClassUsers();

		//CRAFTERS OF THE MONTH
		$crafter_of_month = $ClassUser->getCraftersOfMonth();
		$ClassUser->user_id_product = $crafter_of_month->user_id;
		$user_month_products = $ClassUser->getProductOfUser(4, $ClassUser->user_id_product);

		//POPULAR CRAFTERS
		$popular_crafters = $ClassUser->getPopularCrafters();
		foreach ($popular_crafters as $popular_crafter) {
			$ClassUser->user_id_product = $popular_crafter->user_id_product;
			$popular_crafter->creas = $ClassUser->getProductOfUser(6, $ClassUser->user_id_product);
		}

		//PRODUITS DE LA LISTE PRINCIPALE
		$ClassProduct->limit = '0,' . $this->nb_by_page;
		$products = $ClassProduct->getListFront();
		foreach ($products as $product) {
			$ClassProduct->product_id = $product->product_id;
			$nb_like = $ClassProduct->numberOfLike();
			$product->nb_like = $nb_like->nb_like;
			if ($product->nb_like > 0) {
				$product->name_likes = $ClassProduct->getUsersWhoLiked();
				if (isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] === true) {
					$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];
					$product->did_i_like = $ClassProduct->didILike();
				}
			}
		}

		/*************************************************************
		 * 	APPEL TOOLS												**
		 * **********************************************************/
		$toolsToLoad = array('bootstrap-css', 'font-awesome');

		/*************************************************************
		 * 	VARIABLES LAYOUT										**
		 * **********************************************************/
		DEFINE("_METATITLE", "Accueil");
		DEFINE("_METADESCRIPTION", "Accueil");

		/*************************************************************
		 * 	VUE														**
		 * **********************************************************/
		include_once('../app/views/index/display.php');
	}

	/**
	 * @param $arrayTools
	 * @param $notices
	 */
	function ajax_more($arrayTools, $notices)
	{
		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();
		$min = ($_POST['page'] - 1) * $this->nb_by_page;
		$ClassProduct->limit = $min . ',' . $this->nb_by_page;
		//echo $ClassProduct->limit;exit();
		$products = $ClassProduct->getListFront();
		if (!empty($products)) {
			foreach ($products as $product) {
				$ClassProduct->product_id = $product->product_id;
				$nb_like = $ClassProduct->numberOfLike();
				$product->nb_like = $nb_like->nb_like;
				if (isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] == true) {
					$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];
					$product->did_i_like = $ClassProduct->didILike();
				} else {
					$product->did_i_like = 2;
				}

			}

			$json = json_encode($products);
			echo $json;
			exit();
		} else {
			echo 'no more';
		}
	}

	/**
	 *
	 */
	function ajax_like_product()
	{
		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();

		$ClassProduct->product_id = $_POST['product'];
		$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];

		if ($ClassProduct->didILike() === false) {

			if ($ClassProduct->likeProduct()) {
				echo true;
			} else {
				echo false;
			}
		} else {
			echo 2;
		}
	}

	/**
	 *
	 */
	function ajax_unlike_product()
	{
		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();

		$ClassProduct->product_id = $_POST['product'];
		$ClassProduct->user_id = $_SESSION["CRAFTERS-USER"]["id"];

		if ($ClassProduct->unlikeProduct()) {
			echo true;
		} else {
			echo false;
		}
	}

}

?>