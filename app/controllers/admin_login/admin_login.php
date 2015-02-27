<?php
class loginController
{

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


	function main($arrayTools, $notices)
	{
		
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################


		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js");
		$stylesToLoad = array("style", 'signin');
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Login Admin");
		DEFINE("_METADESCRIPTION", "Login Admin");
		
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/admin_login/display.php');
	
	}
}

?>