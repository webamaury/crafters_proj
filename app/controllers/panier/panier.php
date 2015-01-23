<?php

/**
 * Class PanierController
 */
class PanierController extends CoreControlers {

	/**
	 *
	 */
	function __construct($arrayTools, $notices) {
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
	 * Permet d'afficher la page du panier
	 */
	public function main() {

	}

	/**
	 * Permet d'ajouter un produit au panier
	 */
	public function addToCart() {
		$productId = $_GET['product'];
		if(!isset($_SESSION['CRAFTERS_CART'][$productId])) {
			$_SESSION['CRAFTERS_CART'][$productId] = 1;
		} else {
			$_SESSION['CRAFTERS_CART'][$productId] ++;
		}
	}

	/**
	 * Permet de supprimer un produit du panier
	 */
	public function deleteFromCart() {

	}

	/**
	 * Permet de supprimer un panier entier
	 */
	public function deleteAllCart() {

	}

}

?>