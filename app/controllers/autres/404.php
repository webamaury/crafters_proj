<?php
class AutreController extends CoreControlers {
	
	function __construct($arrayTools, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($arrayTools, $notices) ;

	}

	function main($arrayTools, $notices) {

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
}

?>
