<?php

class configController extends CoreControlers
{
	function __construct($arrayTools, $notices, $modules)
	{
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################


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
		include_once( _APP_PATH . 'views/admin_config/display.php');	}

}

?>