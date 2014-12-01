<?php
	class indexController {
	
		function __construct($array_tools, $notices, $modules) {
			
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		
		
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$tools_to_load = array("bootstrap-css", "jquery" , "bootstrap-js");
		$styles_to_load = array("style");
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Accueil Admin");
		DEFINE("_METADESCRIPTION", "Accueil Admin");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/admin_index/display.php');
				
		}
		
	}
?>