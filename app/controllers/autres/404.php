<?php
class autreController extends CoreControlers {
	
	function __construct($array_tools, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($array_tools, $notices) ;

	}

	function main($array_tools, $notices) {

		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
		$styles_to_load = array("style");
		
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
}

?>
