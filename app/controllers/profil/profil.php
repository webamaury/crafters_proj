<?php
class profilController extends CoreControlers {
		
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
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new classUsers();
		$ClassUser->user_id = $_GET['user'];
		$user = $ClassUser->get_one();
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$tools_to_load = array('bootstrap-css', 'font-awesome');
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Accueil");
		DEFINE("_METADESCRIPTION", "Accueil");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/profil/display.php');
	}
}

?>