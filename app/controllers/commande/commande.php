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


}

?>