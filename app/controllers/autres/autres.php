<?php
class AutreController extends CoreControlers {
	
	function __construct($arrayCss, $arrayJs, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}

		$this->$method($arrayCss, $arrayJs, $notices) ;

	}

	/**
	 * 404
	 * @param $arrayCss, $arrayJs
	 * @param $notices
	 */
	function main($arrayCss, $arrayJs, $notices)
	{
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'panier.js');
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Admin 404");
		DEFINE("_METADESCRIPTION", "Admin 404");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/autres/404.php');
	}

	/**
	 *
	 */
	function messagePage($arrayCss, $arrayJs, $notices)
	{
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		//$_SESSION[_SES_NAME]['pageMessage']=3;
		if (!isset($_SESSION[_SES_NAME]['pageMessage'])) {
			header('location:index.php');
		}
		//TABLEAU DES MESSAGES
		$arrayMessage = array(
			'0' => array(
				'icon' => '<i class="fa fa-gift"></i>',
				'header' => 'Payment done !',
				'content' => 'Everything was okay, you will receive your order soon'
			),
			'1' => array(
				'icon' => '<i class="fa fa-times"></i>',
				'header' => 'This transaction has already been payed',
				'content' => 'Contact us for more informations.'
			),
			'2' => array(
				'icon' => '<i class="fa fa-envelope"></i>',
				'header' => 'Your account has been created !',
				'content' => 'You will receive an e-mail to confirm it.'
			),
			'3' => array(
				'icon' => '<i class="fa fa-check"></i>',
				'header' => 'Your account is now valid !',
				'content' => 'You can entirely enjoy Crafters.'
			),
			'4' => array(
				'icon' => '<i class="fa fa-gift"></i>',
				'header' => 'Your oder has been taken into consideration !',
				'content' => 'We are waiting for your check to send it to you.'
			),
			'5' => array(
				'icon' => '<i class="fa fa-envelope-o"></i>',
				'header' => 'Your message has been sent.',
				'content' => 'We will deal with your request as soon as possible.'
			),

		);

		$icon = $arrayMessage[$_SESSION[_SES_NAME]['pageMessage']]['icon'];
		$header = $arrayMessage[$_SESSION[_SES_NAME]['pageMessage']]['header'];
		$content = $arrayMessage[$_SESSION[_SES_NAME]['pageMessage']]['content'];

		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'panier.js');

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Crafters | Page Message");
		DEFINE("_METADESCRIPTION", "Crafters | Page Message");

		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/autres/message.php');
	}
	function whoweare($arrayCss, $arrayJs, $notices)
	{
		/* **********************************************************
		 * TRAITEMENT PHP
		 ********************************************************** */

		/* **********************************************************
		 * APPEL TOOLS
		 ********************************************************** */
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'panier.js');

		/* **********************************************************
		 * VARIABLES LAYOUT
		 ********************************************************** */
		DEFINE("_METATITLE", "Whe wo are | Crafters");
		DEFINE("_METADESCRIPTION", "Crafters | Tattoo and stickers designers | Who we are");

		/* **********************************************************
		 * VUE
		 ********************************************************** */
		include_once( _APP_PATH . 'views/autres/whoweare.php');
	}
	function terms($arrayCss, $arrayJs, $notices)
	{
		/* **********************************************************
		 * TRAITEMENT PHP
		 ********************************************************** */

		/* **********************************************************
		 * APPEL TOOLS
		 ********************************************************** */
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'panier.js');

		/* **********************************************************
		 * VARIABLES LAYOUT
		 ********************************************************** */
		DEFINE("_METATITLE", "Whe wo are | Crafters");
		DEFINE("_METADESCRIPTION", "Crafters | Tattoo and stickers designers | Who we are");

		/* **********************************************************
		 * VUE
		 ********************************************************** */
		include_once( _APP_PATH . 'views/autres/terms.php');
	}
	function privacy($arrayCss, $arrayJs, $notices)
	{
		/* **********************************************************
		 * TRAITEMENT PHP
		 ********************************************************** */

		/* **********************************************************
		 * APPEL TOOLS
		 ********************************************************** */
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'list.js', 'panier.js');

		/* **********************************************************
		 * VARIABLES LAYOUT
		 ********************************************************** */
		DEFINE("_METATITLE", "Whe wo are | Crafters");
		DEFINE("_METADESCRIPTION", "Crafters | Tattoo and stickers designers | Who we are");

		/* **********************************************************
		 * VUE
		 ********************************************************** */
		include_once( _APP_PATH . 'views/autres/privacy.php');
	}

	function wait()
	{
		/* **********************************************************
		 * TRAITEMENT PHP
		 ********************************************************** */
		if (isset($_POST['mail_notif']) && !empty($_POST['mail_notif'])) {
			include_once(_APP_PATH . 'models/class.users.php');
			$ClassUsers = new ClassUsers();


			$ClassUsers->mail = $_POST['mail_notif'];
			if ($ClassUsers->BDDmailUnique()) {
				$ClassUsers->insertMailNotif();
				header('location:index.php?mess=good');
			} else {
				header('location:index.php?mess=already');
			}

		}

		/* **********************************************************
		 * VUE
		 ********************************************************** */
		include_once( _APP_PATH . 'views/autres/wait.php');
	}

	function standby()
	{
		/* **********************************************************
		 * TRAITEMENT PHP
		 ********************************************************** */
		/* **********************************************************
		 * VUE
		 ********************************************************** */
		include_once( _APP_PATH . 'views/autres/standby.php');
	}
}

?>
