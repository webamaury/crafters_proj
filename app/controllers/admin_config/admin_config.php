<?php

class configController extends CoreController
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

		$jsonConfig = file_get_contents(_APP_PATH . 'controllers/admin_config/file.json');

		//var_dump($jsonConfig);

		$config = json_decode($jsonConfig);

		//var_dump($config);

		//file_put_contents(_APP_PATH . 'controllers/admin_config/file.json', 'hehehehehe');

		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$toolsToLoad = array("bootstrap-css", "jquery" , "bootstrap-js");
		$stylesToLoad = array("style");

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Config Admin");
		DEFINE("_METADESCRIPTION", "Config Admin");

		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/admin_config/display.php');
	}
	function modifFile($arrayTools, $notices, $module)
	{
		if(!isset($_POST)) {
			header('location:index.php');
		}
		$arrayToEncode = array();
		if(isset($_POST['rewurl'])) {
			$arrayToEncode['rewurl'] = $_POST['rewurl'];
		} else {
			$arrayToEncode['rewurl'] = "false";
		}
		if(isset($_POST['standby'])) {
			$arrayToEncode['standby'] = $_POST['standby'];
		} else {
			$arrayToEncode['standby'] = "false";
		}
		if(isset($_POST['debug'])) {
			$arrayToEncode['debug'] = $_POST['debug'];
		} else {
			$arrayToEncode['debug'] = "false";
		}

		$jsonPost = json_encode($arrayToEncode);

		file_put_contents(_APP_PATH . 'controllers/admin_config/file.json', $jsonPost);

		$notices->createNotice("success", "Config successfully updated!");
		header('location:index.php?module=config');
	}
}

?>