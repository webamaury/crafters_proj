<?php
class loginController {
	
	function __construct($array_tools) {
		
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		
		
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js");
		$styles_to_load = array("style", 'signin');
		
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