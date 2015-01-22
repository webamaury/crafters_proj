<?php
class loginController {
	
	function __construct($arrayTools) {
		
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