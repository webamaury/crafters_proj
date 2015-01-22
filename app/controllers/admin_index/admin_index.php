<?php
	class indexController {
	
		function __construct($arrayTools, $notices, $modules) {
			
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
		DEFINE("_METATITLE", "Accueil Admin");
		DEFINE("_METADESCRIPTION", "Accueil Admin");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/admin_index/display.php');
				
		}
		
	}
?>