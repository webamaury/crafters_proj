<?php
class galleryController extends CoreControlers {

	function __construct($arrayTools, $notices) {
		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		} else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if(isset($_GET['action'])) {
			$method = $_GET['action'];
		}
		$this->nb_by_page = 12;
		$this->$method($arrayTools, $notices) ;
	}

	function main($arrayTools, $notices) {

		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();
		include_once(_APP_PATH . 'models/class.users.php');
		$ClassUser = new ClassUsers();

		//PRODUITS DE LA LISTE
		if (isset($_GET['order'])) {
			if ($_GET['order'] == 'popular') {
				$orderby = 'product_nblike DESC';
			} else if ($_GET['order'] == 'newest') {
				$orderby = 'product_id DESC';
			} else {
				$orderby = 'product_id DESC';
			}
		} else {
			$orderby = 'product_id DESC';
		}
		if (isset($_GET['search'])) {
			$search = " AND (P.product_name LIKE '%" . $_GET['search'] . "%' OR P.product_description LIKE '%" . $_GET['search'] . "%' OR U.user_username LIKE '%" . $_GET['search'] . "%')";
		} else {
			$search = "";
		}
		$ClassProduct->limit = '0,' . $this->nb_by_page;
		$products = $ClassProduct->getListFront($orderby, $search);
		//var_dump($products);
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
		$toolsToLoad = array('bootstrap-css', 'font-awesome');

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Upload");
		DEFINE("_METADESCRIPTION", "Upload");


		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/gallery/display.php');

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
		$products = $ClassProduct->getListFront();
		if (!empty($products)) {
			foreach ($products as $product) {
				$ClassProduct->product_id = $product->product_id;
				$nb_like = $ClassProduct->numberOfLike();
				$product->nb_like = $nb_like->nb_like;
				if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
					$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];
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
		$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];

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
		$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];

		if ($ClassProduct->unlikeProduct()) {
			echo true;
		} else {
			echo false;
		}
	}

	function search() {

		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();

		$ClassProduct->product_search = $_GET["term"] . "%";

	}
}

?>