<?php

/**
 * Class SignUpController
 */
class SignUpController extends CoreControlers
{
	function __construct($arrayTools, $notices) {
		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($arrayTools, $notices) ;
	}
	/**
	 * @param $arrayTools
	 * @param $notices
	 */
	function main($arrayTools, $notices)
	{
		/*************************************************************
		 * 	TRAITEMENT PHP											**
		 * **********************************************************/
		
		
		/*************************************************************
		 * 	APPEL TOOLS												**
		 * **********************************************************/
		$toolsToLoad = array('bootstrap-css', 'font-awesome');

		/*************************************************************
		 * 	VARIABLES LAYOUT										**
		 * **********************************************************/
		DEFINE("_METATITLE", "Sign Up");
		DEFINE("_METADESCRIPTION", "Sign Up");

		/*************************************************************
		 * 	VUE														**
		 * **********************************************************/
		include_once('../app/views/signup/display.php');
	}
	
	public function signup($arrayTools, $notices)
	{
		//Add Crafters
		if (empty($_POST['firstname']) || empty($_POST['name']) || empty($_POST['username']) || empty($_POST['mail']) || empty($_POST['password']) || empty($_POST['confirmpassword'])) {
		
			$notices->createNotice('danger', 'Veuillez remplir tous les champs.');
			header("location:index.php?module=signup");

		} else if($_POST['password'] =! $_POST['confirmpassword']) {

			$notices->createNotice('danger', 'Veuillez entrer le meme mote de passe.');
			header("location:index.php?module=signup");
			
		} else {
			include_once(_APP_PATH . 'models/class.users.php');
			$ClassUser = new ClassUsers();
		
			$ClassUser->firstname 	= $_POST['firstname'];
			$ClassUser->name 		= $_POST['name'];
			$ClassUser->username 	= $_POST['username'];
			$ClassUser->mail 		= $_POST['mail'];
			$ClassUser->password 	= md5($_POST['password']);
			
	
			$add_crafter = $ClassUser->signup();
			if( $add_crafter == true) {
				$notices->createNotice('success', 'Votre compte a bien été crée vous allez recevoir un mail pour le valider');
				header("location:index.php?module=index");
			} else {
				$notices->createNotice('danger', 'Problème d`inscription. Merci de réessayer plus tard');
				header("location:index.php?module=signup");
			}
		}
	}
}
?>