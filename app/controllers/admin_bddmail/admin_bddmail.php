<?php

class bddmailController extends CoreController
{
	function __construct($arrayTools, $notices, $modules)
	{
		if (!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main';
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}

		$this->$method($arrayTools, $notices, $modules);
	}


	function main($arrayTools, $notices, $modules)
	{

		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		$items = array();

		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$toolsToLoad = array("bootstrap-css", "jquery" , "bootstrap-js");
		$stylesToLoad = array("style");

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Bdd mail Admin");
		DEFINE("_METADESCRIPTION", "Bdd mmail Admin");

		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/admin_bddmail/display.php');
	}

}

?>