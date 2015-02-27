<?php

/**
 * Class IndexController
 */
class commandeController extends CoreController
{

	/**
	 * @param $arrayCss, $arrayJs
	 * @param $notices
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
	 * @param $arrayCss, $arrayJs
	 * @param $notices
	 */
	function main($arrayCss, $arrayJs, $notices)
	{
		/*************************************************************
		 *    TRAITEMENT PHP                                            **
		 * **********************************************************/
		if (!isset($_SESSION[_SES_NAME]['Cart']) || empty($_SESSION[_SES_NAME]['Cart'])) {
			$notices->createNotice('danger', 'Pas de produit dans le panier');
			header('location:index.php');
			exit();
		}
		$delivery = $_SESSION[_SES_NAME]['Delivery'];
		if ($delivery == 0) {
			$deliveryPrice = 6;
		} else {
			$deliveryPrice = 10;
		}
		//var_dump($_SESSION[_SES_NAME], $delivery);

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
		 *    APPEL TOOLS                                                **
		 * **********************************************************/
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'panier.js');

		/*************************************************************
		 *    VARIABLES LAYOUT                                        **
		 * **********************************************************/
		DEFINE("_METATITLE", "Order");
		DEFINE("_METADESCRIPTION", "Order");

		/*************************************************************
		 *    VUE                                                        **
		 * **********************************************************/
		//var_dump($_SESSION[_SES_NAME]['Cart']);

		include_once('../app/views/commande/display.php');
	}

	public function payWithPaypal($arrayCss, $arrayJs, $notices)
	{
		if (!isset($_POST['address']) || !isset($_POST['zipcode']) || !isset($_POST['city']) || !isset($_POST['more'])) {
			$notices->createNotice("danger", "Veuillez remplir tous les champs!");
			header('location:index.php?module=commande');
			exit();
		} else if (!isset($_POST['optradio']) || $_POST['optradio'] != 1) {
			$notices->createNotice("danger", "Veuillez accepter les conditions générales");
			header('location:index.php?module=commande');
			exit();
		}
		//var_dump($_POST, $_SESSION[_SES_NAME]);exit();

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

		$ClassCommandes->order_custom 			= serialize($_SESSION[_SES_NAME]['Cart']);
		$ClassCommandes->user_id 			= $_SESSION[_SES_NAME]['id'];
		$ClassCommandes->order_hash 		= substr(strtoupper(md5(time() . session_id())), 0, 8);
		$ClassCommandes->order_delivery 	= $_SESSION[_SES_NAME]['Delivery'];
		$ClassCommandes->ad_firstname 		= $_POST['firstname'];
		$ClassCommandes->ad_name 			= $_POST['name'];
		$ClassCommandes->ad_numberstreet 	= $_POST['address'];
		$ClassCommandes->ad_zipcode 		= $_POST['zipcode'];
		$ClassCommandes->ad_city 			= $_POST['city'];
		$ClassCommandes->ad_more 			= $_POST['more'];
		$ClassCommandes->ad_status 			= 1;
		$ClassCommandes->products 			= $_SESSION[_SES_NAME]['Cart'];


		$return = $ClassCommandes->insertCommande();
		//var_dump($ClassCommandes, $return);exit();
		if ($return != false) {
			$_SESSION[_SES_NAME]['order'] = $return;
			header('location:index.php?module=commande&action=delivery');
		}
	}

	/**
	 * @param $arrayCss, $arrayJs
	 * @param $notices
	 */
	function delivery($arrayCss, $arrayJs, $notices)
	{
		/*************************************************************
		 *    TRAITEMENT PHP                                            **
		 * **********************************************************/
		include_once(_APP_PATH . 'controllers/paypal/paypal.php') ;
		include_once(_APP_PATH . 'models/class.commande.php');
		$ClassCommandes = new ClassCommandes();
		$ClassCommandes->order_id = $_SESSION[_SES_NAME]['order'];
		//unset($_SESSION[_SES_NAME]['order']);
		$commande = $ClassCommandes->get_commande();
		$adressesCommande = $ClassCommandes->getAdressesCommande($commande->order_id);

		//var_dump($commande,$adressesCommande);


		$totalttc = $commande->order_price;
		if ($commande->order_delivery == 0) {
			$port = 6;
		} else {
			$port = 10;
		}

		//var_dump($commande, $port);exit();

		$paypal = new Paypal();
		$params = array(
			'RETURNURL' => _PATH_FOLDER . 'index.php?module=commande&action=success',
			'CANCELURL' => _PATH_FOLDER . 'index.php?module=commande&action=cancel',

			'PAYMENTREQUEST_0_AMT' => $totalttc + $port,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
			'PAYMENTREQUEST_0_SHIPPINGAMT' => $port,
			'PAYMENTREQUEST_0_ITEMAMT' => $totalttc,

			'PAYMENTREQUEST_0_SHIPTONAME' => $adressesCommande[0]->address_firstname. " " . $adressesCommande[0]->address_name,
			'PAYMENTREQUEST_n_SHIPTOSTREET' => $adressesCommande[0]->address_numberstreet,
			'PAYMENTREQUEST_n_SHIPTOCITY' => $adressesCommande[0]->address_town,
			'PAYMENTREQUEST_n_SHIPTOZIP' => $adressesCommande[0]->address_zipcode,
			'PAYMENTREQUEST_n_SHIPTOCOUNTRYCODE' => '33'
		);
		$i = 0;
		foreach($_SESSION[_SES_NAME]['Cart'] as $k => $product){
			$params["L_PAYMENTREQUEST_0_NAME$i"] = $product['name'];
			$params["L_PAYMENTREQUEST_0_DESC$i"] = $product['type'];
			if ($product['size'] == 's') {
				$params["L_PAYMENTREQUEST_0_AMT$i"] = 5;
			} else if ($product['size'] == 'm') {
				$params["L_PAYMENTREQUEST_0_AMT$i"] = 10;
			} else if ($product['size'] == 'l') {
				$params["L_PAYMENTREQUEST_0_AMT$i"] = 15;
			}
			$params["L_PAYMENTREQUEST_0_QTY$i"] = $product['quantity'];
			$i++;
		}
		$response = $paypal->request('SetExpressCheckout', $params);
		if($response){
			$paypalurl = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . $response['TOKEN'];
		}else{
			var_dump($paypal->errors);
			die('Erreur ');
		}


		/*************************************************************
		 *    APPEL TOOLS                                                **
		 * **********************************************************/
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'jquery.ui', 'list.js', 'loadmore.js', 'panier.js');

		/*************************************************************
		 *    VARIABLES LAYOUT                                        **
		 * **********************************************************/
		DEFINE("_METATITLE", "Delivery");
		DEFINE("_METADESCRIPTION", "Delivery");

		/*************************************************************
		 *    VUE                                                        **
		 * **********************************************************/
		include_once('../app/views/delivery/display.php');
	}

	function success($arrayCss, $arrayJs, $notices)
	{
		include_once(_APP_PATH . 'models/class.commande.php'); $ClassCommandes = new ClassCommandes();

		$ClassCommandes->order_id = $_SESSION[_SES_NAME]['order'];
		//unset($_SESSION[_SES_NAME]['order']);
		$commande = $ClassCommandes->get_commande();
		$adressesCommande = $ClassCommandes->getAdressesCommande($commande->order_id);

		$infosclient = array(
			"name" => $_SESSION[_SES_NAME]['firstname'] . " " . $_SESSION[_SES_NAME]['name'] ,
			"adr1" => $adressesCommande[0]->address_numberstreet,
			"adr2" => $adressesCommande[0]->address_zipcode . " " . $adressesCommande[0]->address_town
		);
		$infospanier = $_SESSION[_SES_NAME]['Cart'];
		$infoscommande = $commande;



		//var_dump($infosclient, $infospanier, $infoscommande);exit();

		$totalttc = $commande->order_price;
		$port = 10.0;


		include_once(_APP_PATH . 'controllers/paypal/paypal.php') ;
		$paypal = new Paypal();

		$response = $paypal->request('GetExpressCheckoutDetails', array(
			'TOKEN' => $_GET['token']
		));
		if($response){
			if($response['CHECKOUTSTATUS'] == 'PaymentActionCompleted'){
				$_SESSION[_SES_NAME]['pageMessage'] = 1;
				header('location:index.php?module=autre&action=messagePage');
			} else {
				//Everything is OK
			}
		}else{
			//var_dump($paypal->errors);
			die();
		}



		$params = array(
			'TOKEN' => $_GET['token'],
			'PAYERID'=> $_GET['PayerID'],
			'PAYMENTACTION' => 'Sale',

			'PAYMENTREQUEST_0_AMT' => $totalttc + $port,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
			'PAYMENTREQUEST_0_SHIPPINGAMT' => $port,
			'PAYMENTREQUEST_0_ITEMAMT' => $totalttc,
		);
		$i = 0;
		foreach($_SESSION[_SES_NAME]['Cart'] as $k => $product){
			$params["L_PAYMENTREQUEST_0_NAME$i"] = $product['name'];
			$params["L_PAYMENTREQUEST_0_DESC$i"] = '';
			if ($product['size'] == 's') {
				$params["L_PAYMENTREQUEST_0_AMT$i"] = 5;
			} else if ($product['size'] == 'm') {
				$params["L_PAYMENTREQUEST_0_AMT$i"] = 10;
			} else if ($product['size'] == 'l') {
				$params["L_PAYMENTREQUEST_0_AMT$i"] = 15;
			}
			$params["L_PAYMENTREQUEST_0_QTY$i"] = $product['quantity'];
			$i++;
		}
		$response = $paypal->request('DoExpressCheckoutPayment',$params);
		if($response){
			//var_dump($response);
			//$response['PAYMENTINFO_0_TRANSACTIONID'];
			$ClassCommandes->statusPayed();

			$ClassCommandes->order_payment_mode = 0;
			$ClassCommandes->paymentMode();



			$this->generateFacture($infosclient, $infospanier, $infoscommande);

			unset($_SESSION[_SES_NAME]['order']);
			unset($_SESSION[_SES_NAME]['Cart']);
			unset($_SESSION[_SES_NAME]['Delivery']);

			$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.payment.htm');

			// On remplace les infos personnelles
			$tpl = str_replace("%PAY_MODE%", 'Paypal payment', $tpl);
			$tpl = str_replace("%ORDER_HASH%", $commande->order_hash, $tpl);


			$this->send_mail($tpl,
				_SITE_NAME,
				'amaury.gilbon@gmail.com',
				$_SESSION[_SES_NAME]['mail'],
				'Order [' . $commande->order_hash . '] confirmation',
				"",
				$commande->order_hash);

			$_SESSION[_SES_NAME]['pageMessage'] = 0;
			header('location:index.php?module=autre&action=messagePage');

		}else{
			//var_dump($paypal->errors);
		}

	}
	function payCheck()
	{
		//var_dump($_SESSION[_SES_NAME]);exit();
		include_once(_APP_PATH . 'models/class.commande.php');
		$ClassCommandes = new ClassCommandes();
		$ClassCommandes->order_id = $_SESSION[_SES_NAME]['order'];
		$commande = $ClassCommandes->get_commande();
		$ClassCommandes->order_payment_mode = 1;
		$ClassCommandes->paymentMode();

		unset($_SESSION[_SES_NAME]['order']);
		unset($_SESSION[_SES_NAME]['Cart']);
		unset($_SESSION[_SES_NAME]['Delivery']);

		/*$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.payment.htm');

		// On remplace les infos personnelles
		$tpl = str_replace("%PAY_MODE%", 'Check', $tpl);
		$tpl = str_replace("%ORDER_HASH%", $commande->order_hash, $tpl);


		$this->send_mail($tpl,
			_SITE_NAME,
			'amaury.gilbon@gmail.com',
			$_SESSION[_SES_NAME]['mail'],
			'Order [' . $commande->order_hash . '] confirmation');*/

		$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.check.htm');

		// On remplace les infos personnelles
		$tpl = str_replace("%ORDER_HASH%", $commande->order_hash, $tpl);


		$this->send_mail($tpl,
			_SITE_NAME,
			'amaury.gilbon@gmail.com',
			$_SESSION[_SES_NAME]['mail'],
			'Order [' . $commande->order_hash . '] confirmation');

		$_SESSION[_SES_NAME]['pageMessage'] = 4;
		header('location:index.php?module=autre&action=messagePage');
	}
}

?>