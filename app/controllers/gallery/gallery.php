<?php
class galleryController extends CoreControlers {

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
		$toolsToLoad = array('bootstrap-css', 'font-awesome');

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Upload");
		DEFINE("_METADESCRIPTION", "Upload");


		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/gallery/display.php');

	}

}

?>