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
	function __construct($arrayCss, $arrayJs, $notices)
	{

		if (!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main';
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		}
		$this->nb_by_page = 12;
		//if(isset($_SESSION[_SES_NAME]))var_dump($_SESSION[_SES_NAME]);

		$this->$method($arrayCss, $arrayJs, $notices);
	}

	/**
	 * @param $arrayTools
	 * @param $notices
	 */
	function main($arrayCss, $arrayJs, $notices)
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
				if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] === true) {
					$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];
					$product->did_i_like = $ClassProduct->didILike();
				}
			}
		}

		/*************************************************************
		 * 	APPEL TOOLS												**
		 * **********************************************************/
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'panier.js');

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
	function ajax_more($arrayCss, $arrayJs, $notices)
	{
		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();
		$min = ($_POST['page'] - 1) * $this->nb_by_page;
		$ClassProduct->limit = $min . ',' . $this->nb_by_page;
		//echo $ClassProduct->limit;exit();
		if (isset($_POST['order'])) {
			if ($_POST['order'] == 'popular') {
				$orderby = 'product_nblike DESC';
			} else if ($_POST['order'] == 'newest') {
				$orderby = 'product_id DESC';
			} else {
				$orderby = 'product_id DESC';
			}
		} else {
			$orderby = 'product_id DESC';
		}
		if (isset($_POST['search'])) {
			$search = " AND (P.product_name LIKE '%" . $_POST['search'] . "%' OR P.product_description LIKE '%" . $_POST['search'] . "%' OR U.user_username LIKE '%" . $_POST['search'] . "%')";
		} else {
			$search = "";
		}
		$products = $ClassProduct->getListFront($orderby, $search);
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

	/**
	 *
	 */
	function contact($arrayCss, $arrayJs, $notices)
	{
		if (!isset($_POST['firstname']) || empty($_POST['firstname']) || !isset($_POST['name']) || empty($_POST['name']) || !isset($_POST['mail']) || empty($_POST['mail']) || !isset($_POST['message']) || empty($_POST['message'])) {
			$notices->createNotice("danger", "Please complete all required fields!");
			header('location:index.php');
			exit();
		}
		include_once(_APP_PATH . 'models/class.messages.php');
		$message = new ClassMessages();

		$message->message_firstname = $_POST['firstname'];
		$message->message_name = $_POST['name'];
		$message->message_mail = $_POST['mail'];
		$message->message_message = $_POST['message'];

		$message->newMessage();

		$_SESSION[_SES_NAME]['pageMessage'] = 5;
		header('location:index.php?module=autre&action=messagePage');

	}
}

?>