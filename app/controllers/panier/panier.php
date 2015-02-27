<?php

/**
 * Class PanierController
 */
class PanierController extends CoreController
{

	/**
	 *
	 */
	function __construct($arrayCss, $arrayJs, $notices)
	{
		if (!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main';
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}
		$this->$method($arrayCss, $arrayJs, $notices);
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
		if(!isset($_SESSION[_SES_NAME]['Delivery'])) {
			$_SESSION[_SES_NAME]['Delivery'] = 0;
		}

		if(!isset($_SESSION[_SES_NAME]['Cart'][$productId])) {
			$_SESSION[_SES_NAME]['Cart'][$productId]['quantity'] = 1;
			$_SESSION[_SES_NAME]['Cart'][$productId]['name'] = $_GET['name'];
			$_SESSION[_SES_NAME]['Cart'][$productId]['from'] = $_GET['from'];
			$_SESSION[_SES_NAME]['Cart'][$productId]['img_url'] = $_GET['img_url'];
			$_SESSION[_SES_NAME]['Cart'][$productId]['size'] = "m";
			$_SESSION[_SES_NAME]['Cart'][$productId]['type'] = "Tattoo";

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
		$key = $_GET['product'];
		unset($_SESSION[_SES_NAME]['Cart'][$key]);
		$json['totalPrice'] = $this->calculateTotalPrice();
		$json['nb_product'] = $this->nbProduct();
		echo json_encode($json);
		exit();
	}

	/**
	 * Permet de supprimer un panier entier
	 */
	public function changeQuantity()
	{
		$product = $_GET['product'];
		if (isset($_SESSION[_SES_NAME]['Cart'][$product]['quantity'])) {

			if ($_GET['move'] == 'more') {
					$_SESSION[_SES_NAME]['Cart'][$product]['quantity']++;
					$json['message'] = 'more';
					$json['quantity'] = $_SESSION[_SES_NAME]['Cart'][$product]['quantity'];

			} else if ($_GET['move'] == 'less') {
				$_SESSION[_SES_NAME]['Cart'][$product]['quantity']--;
				$json['quantity'] = $_SESSION[_SES_NAME]['Cart'][$product]['quantity'];
				if ($_SESSION[_SES_NAME]['Cart'][$product]['quantity'] <= 0) {
					unset($_SESSION[_SES_NAME]['Cart'][$product]);
				}
				$json['message'] = 'less';
			}
		} else {
			$json['quantity'] = 0;
		}
		$json['totalPrice'] = $this->calculateTotalPrice();
		$json['nb_product'] = $this->nbProduct();

		$json =json_encode($json);
		echo $json;
		exit();
	}
	private function calculateTotalPrice()
	{
		$totalPrice = 0 ;
		foreach ($_SESSION[_SES_NAME]['Cart'] as $product) {
			if ($product['size'] == 's') {
				$totalPrice += $product['quantity'] * 5;
			} else if ($product['size'] == 'm') {
				$totalPrice += $product['quantity'] * 10;
			} else if ($product['size'] == 'l') {
				$totalPrice += $product['quantity'] * 15;
			}
		}
		if (!isset($_SESSION[_SES_NAME]['Delivery'])) {
			$_SESSION[_SES_NAME]['Delivery'] = 0;
		}
		if ($_SESSION[_SES_NAME]['Delivery'] == 0) {
			$totalPrice += 6;
		} else {
			$totalPrice += 10;
		}
		return $totalPrice;
	}
	private function nbProduct() {
		$quantity = 0 ;
		foreach ($_SESSION[_SES_NAME]['Cart'] as $product) {
			$quantity += $product['quantity'];
		}
		return $quantity;
	}
	public function changeSize()
	{
		$product = $_GET['product'];
		$size = $_GET['size'];
		$_SESSION[_SES_NAME]['Cart'][$product]['size'] = $size;
		$json['totalPrice'] = $this->calculateTotalPrice();
		echo json_encode($json);
	}
	public function changeType()
	{
		$product = $_GET['product'];
		$type = $_GET['type'];
		$_SESSION[_SES_NAME]['Cart'][$product]['type'] = $type;
		echo true;
	}
	public function changeDelivery()
	{
		if(isset($_SESSION[_SES_NAME]['Delivery'])) {
			if($_SESSION[_SES_NAME]['Delivery'] == 0) {
				$_SESSION[_SES_NAME]['Delivery'] = 1;
			} else {
				$_SESSION[_SES_NAME]['Delivery'] = 0;
			}
		} else {
			$_SESSION[_SES_NAME]['Delivery'] = 0;
		}
		$totalPrice = $this->calculateTotalPrice();
		echo $totalPrice;
	}

}

?>