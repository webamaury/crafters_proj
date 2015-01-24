<?php

/**
 * Class PanierController
 */
class PanierController extends CoreControlers
{

	/**
	 *
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
	 * Permet d'afficher la page du panier
	 */
	public function main()
	{

	}

	/**
	 * Permet d'ajouter un produit au panier
	 */
	public function addToCart()
	{
		$productId = $_GET['product'];

		if(!isset($_SESSION[_SES_NAME]['Cart'][$productId])) {
			$_SESSION[_SES_NAME]['Cart'][$productId]['quantity'] = 1;
			$_SESSION[_SES_NAME]['Cart'][$productId]['name'] = $_GET['name'];
			$_SESSION[_SES_NAME]['Cart'][$productId]['from'] = $_GET['from'];
			$_SESSION[_SES_NAME]['Cart'][$productId]['img_url'] = $_GET['img_url'];
			$_SESSION[_SES_NAME]['Cart'][$productId]['size'] = "m";
			echo true;
		} else {
			$_SESSION[_SES_NAME]['Cart'][$productId]['quantity'] ++;
			echo true;
		}
	}
	/**
	 * Permet de supprimer un produit du panier
	 */
	public function displayCart() {
		if(isset($_SESSION[_SES_NAME]['Cart']) && !empty($_SESSION[_SES_NAME]['Cart'])){
			$json = json_encode($_SESSION[_SES_NAME]['Cart']);
			echo $json;
		} else {
			echo false;
		}

	}
	/**
	 * Permet de supprimer un produit du panier
	 */
	public function deleteFromCart()
	{

	}

	/**
	 * Permet de supprimer un panier entier
	 */
	public function deleteAllCart()
	{

	}

}

?>