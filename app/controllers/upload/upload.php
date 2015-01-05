<?php
class uploadController extends CoreControlers {
	
	function __construct($array_tools, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method() ;
	}
	
	function main() {
	
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		
		
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$tools_to_load = array();
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Upload");
		DEFINE("_METADESCRIPTION", "Upload");
		
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/upload/display.php');

	}
	
	function upload_ajax() {
		if(!empty($_FILES['upload_file'])){
			$max_size = 10000000 ;
			$authorized_extension = array('jpg', 'jpeg', 'png');
			$file_extension = $this->get_extension($_FILES['upload_file']['name']);
			if(in_array($file_extension, $authorized_extension)){
				if($_FILES['upload_file']['size'] < $max_size) {
					var_dump($_FILES['upload_file']);
				}
				else {
					echo 'image too big';
				}
			}
			else {
				echo 'wrong extension';
			}
		}
		else{
			echo 'no file';
		}
	}

}

?>