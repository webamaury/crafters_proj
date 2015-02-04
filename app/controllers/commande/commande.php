<?php

/**
 * Class IndexController
 */
class commandeController extends CoreControlers
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
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}

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
		if (!isset($_SESSION[_SES_NAME]['Cart']) || empty($_SESSION[_SES_NAME]['Cart'])) {
			$notices->createNotice('danger', 'Pas de produit dans le panier');
			header('location:index.php');exit();
		}
		$all_quantity = 0;
		$totalPrice = 0;
		foreach ($_SESSION[_SES_NAME]['Cart'] as $key => $product) {
			$all_quantity += $product['quantity'];
			if ($product['size'] == 's') {
				$totalPrice += $product['quantity'] * 5;
			} else if ($product['size'] == 'm') {
				$totalPrice += $product['quantity'] * 10;
			} else if ($product['size'] == 'l') {
				$totalPrice += $product['quantity'] * 15;
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
		include_once('../app/views/commande/display.php');
	}

	public function payWithPaypal($arrayTools, $notices)
	{
		if (!isset($_POST['address']) ||  !isset($_POST['zipcode']) ||  !isset($_POST['city']) ||  !isset($_POST['more'])) {
			$notices->createNotice("danger", "Veuillez remplir tous les champs!");
			header('location:index.php?module=commande');exit();
		} else if (!isset($_POST['optradio']) || $_POST['optradio'] != 1) {
			$notices->createNotice("danger", "Veuillez accepter les conditions générales");
			header('location:index.php?module=commande');exit();
		}

		include_once(_APP_PATH . 'models/class.commande.php');
		$ClassCommandes = new ClassCommandes();
		$ClassCommandes->price = 0;
		foreach ($_SESSION[_SES_NAME]['Cart'] as $key => $product) {
			if ($product['size'] == 's') {
				$ClassCommandes->price += $product['quantity'] * 5;
			} else if ($product['size'] == 'm') {
				$ClassCommandes->price += $product['quantity'] * 10;
			} else if ($product['size'] == 'l') {
				$ClassCommandes->price += $product['quantity'] * 15;
			}
		}


		$ClassCommandes->user_id = $_SESSION[_SES_NAME]['id'];
		$ClassCommandes->ad_numberstreet = $_POST['address'];
		$ClassCommandes->ad_zipcode = $_POST['zipcode'];
		$ClassCommandes->ad_city = $_POST['city'];
		$ClassCommandes->ad_more = $_POST['more'];
		$ClassCommandes->ad_status = 0;
		$ClassCommandes->products = $_SESSION[_SES_NAME]['Cart'];

		$return = $ClassCommandes->insertCommande();

		if ($return == 1) {
			echo 'good';
		}

	}
}

?>