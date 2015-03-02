<?php

/**
 * Class SignUpController
 */
class SignUpController extends CoreController
{
	function __construct($arrayCss, $arrayJs, $notices) {
		if (!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}
		
		$this->$method($arrayCss, $arrayJs, $notices) ;
	}
	/**
	 * @param $arrayCss, $arrayJs
	 * @param $notices
	 */
	function main($arrayCss, $arrayJs, $notices)
	{
		/*************************************************************
		 * 	TRAITEMENT PHP											**
		 * **********************************************************/
		
		
		/*************************************************************
		 * 	APPEL TOOLS												**
		 * **********************************************************/
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'panier.js', 'signup');

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
	
	public function signup($arrayCss, $arrayJs, $notices)
	{
		//Add Crafters
		if (empty($_POST['firstname']) || empty($_POST['name']) || empty($_POST['username']) || empty($_POST['mail']) || empty($_POST['password']) || empty($_POST['confirmpassword'])) {
		
			$notices->createNotice('danger', 'Veuillez remplir tous les champs.');
			header("location:index.php?module=signup"); exit();

		} else if($_POST['password'] != $_POST['confirmpassword']) {

			$notices->createNotice('danger', 'Veuillez entrer deux mots de passe identiques.');
			header("location:index.php?module=signup"); exit();
			
		} else {
			include_once(_APP_PATH . 'models/class.users.php');
			$ClassUser = new ClassUsers();
		
			$ClassUser->user_firstname 	= $_POST['firstname'];
			$ClassUser->user_name 		= $_POST['name'];
			$ClassUser->user_username 	= $_POST['username'];
			$ClassUser->user_mail 		= $_POST['mail'];
			$ClassUser->user_password 	= md5($_POST['password']);
			
			if (!$ClassUser->mailUnique()) {
				$notices->createNotice('danger', 'This Mail address is already use!');
				header("location:index.php?module=signup"); exit();
			}
			if (!$ClassUser->usernameUnique()) {
				$notices->createNotice('danger', 'This username is already use!');
				header("location:index.php?module=signup"); exit();
			}

			$lastid = $ClassUser->signup();
			if( $lastid == false) {
				$notices->createNotice('danger', 'Signup problem. Please try again later!');
				header("location:index.php?module=signup");
			} else {

				$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.signup.htm');

				// On remplace les infos personnelles
				$url = _PATH_FOLDER . "index.php?module=signup&action=verif&user=" . $lastid;
				$tpl = str_replace("%URL%", $url, $tpl);

				$this->send_mail($tpl,
					_SITE_NAME,
					'amaury.gilbon@gmail.com',
					$_POST['mail'],
					'Confirm your account Crafters');

				$_SESSION[_SES_NAME]['pageMessage'] = 2;
				header('location:index.php?module=autre&action=messagePage');
			}
		}
	}
	
	public function verif($arrayCss, $arrayJs, $notices) {
		
		if (isset($_GET['user']) && !empty($_GET['user'])) {
			include_once(_APP_PATH . 'models/class.users.php');
			$ClassUser = new ClassUsers();
			$ClassUser->user_id = $_GET['user'];
			if ($ClassUser->verif() == true) {
				$_SESSION[_SES_NAME]['pageMessage'] = 3;
				header('location:index.php?module=autre&action=messagePage');
			} else {
				$notices->createNotice('danger', 'Problème lors de la vérification de votre compte, veuillez réessayer plus tard');
				header("location:index.php?module=index");
			}
		}
	}
	function usernameUniqueAjax()
	{
		if (!isset($_GET['username']) || empty($_GET['username'])) {
			echo 'error1'; exit();
		}

		include_once(_APP_PATH . 'models/class.users.php'); $ClassUser = new ClassUsers();
		$ClassUser->user_username = $_GET['username'];
		$return = $ClassUser->usernameUnique();

		echo $return; exit();

	}

	function mailUniqueAjax()
	{
		if (!isset($_GET['mail']) || empty($_GET['mail'])) {
			echo 'error1'; exit();
		}

		include_once(_APP_PATH . 'models/class.users.php'); $ClassUser = new ClassUsers();
		$ClassUser->user_mail = $_GET['mail'];
		$return = $ClassUser->mailUnique();

		echo $return; exit();

	}


}
?>