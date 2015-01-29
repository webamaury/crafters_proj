<?php

/**
 * Class SignUpController
 */
class SignUpController extends CoreControlers
{
	function __construct($arrayTools, $notices) {
		if (!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
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

		} else if($_POST['password'] != $_POST['confirmpassword']) {

			$notices->createNotice('danger', 'Veuillez entrer deux mots de passe identiques.');
			header("location:index.php?module=signup");
			
		} else {
			include_once(_APP_PATH . 'models/class.users.php');
			$ClassUser = new ClassUsers();
		
			$ClassUser->firstname 	= $_POST['firstname'];
			$ClassUser->name 		= $_POST['name'];
			$ClassUser->username 	= $_POST['username'];
			$ClassUser->mail 		= $_POST['mail'];
			$ClassUser->password 	= md5($_POST['password']);
			
			if ($ClassUser->mailUnique()) {
				$lastid = $ClassUser->signup();
				if( $lastid == false) {
					$notices->createNotice('danger', 'Problème d`inscription. Merci de réessayer plus tard');
					header("location:index.php?module=signup");
				} else {
					
					$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.header.htm');
					$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.contact.htm');
					$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.footer.htm');
		
					// On remplace les infos personnelles
					$tpl = str_replace("%CONTENT%", 'Pour confirmer votre compte, veuillez cliquer sur <a href="http://ns366377.ovh.net/chelli/perso/crafters_proj/www/index.php?module=signup&action=verif&user=' . $lastid . '">ce lien</a>  ', $tpl);
					$tpl = str_replace("%SITE_NAME%", _SITE_NAME, $tpl);
	
					$this->send_mail($tpl,
						'Crafters',
						'bossxiii@hotmail.fr',
						$_POST['mail'],
						'Vérification de votre compte Crafters');
						
					$notices->createNotice('success', 'Votre compte a bien été crée vous allez recevoir un mail pour le valider');
					header("location:index.php?module=index");
				}
			} else {
				$notices->createNotice('danger', 'Cette adresse email possède deja un compte');
				header("location:index.php?module=signup");
			}			
		}
	}
	
	public function verif($arrayTools, $notices) {
		
		if (isset($_GET['user']) && !empty($_GET['user'])) {
			include_once(_APP_PATH . 'models/class.users.php');
			$ClassUser = new ClassUsers();
			$ClassUser->user_id = $_GET['user'];
			if ($ClassUser->verif() == true) {
				$notices->createNotice('success', 'Votre compte a bien été validé');
				header("location:index.php?module=index");
			} else {
				$notices->createNotice('danger', 'Problème lors de la vérification de votre compte, veuillez réessayer plus tard');
				header("location:index.php?module=index");
			}
		}
	}
}
?>