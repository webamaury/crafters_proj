<?php
class AutreController extends CoreControlers {
	
	function __construct($arrayTools, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}

		$this->$method($arrayTools, $notices) ;

	}

	/**
	 * 404
	 * @param $arrayTools
	 * @param $notices
	 */
	function main($arrayTools, $notices)
	{
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$toolsToLoad = array("bootstrap-css", 'font-awesome');
		$stylesToLoad = array("style");
		
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
	function messagePage($arrayTools, $notices)
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
		);

		$icon = $arrayMessage[$_SESSION[_SES_NAME]['pageMessage']]['icon'];
		$header = $arrayMessage[$_SESSION[_SES_NAME]['pageMessage']]['header'];
		$content = $arrayMessage[$_SESSION[_SES_NAME]['pageMessage']]['content'];

		unset($_SESSION[_SES_NAME]['pageMessage']);
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$toolsToLoad = array("bootstrap-css", 'font-awesome');
		$stylesToLoad = array("style");

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Admin 404");
		DEFINE("_METADESCRIPTION", "Admin 404");

		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/autres/message.php');
	}
}

?>
