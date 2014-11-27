<?php
##############################################################
##	TRAITEMENT PHP											##
##############################################################
include_once(_APP_PATH . 'models/lib.admin_users.php');
$items = get_list();


if(isset($_GET['action']) && $_GET['action'] == "delete") {
	if(delete_admin($_GET['id'])) {
		create_notice('success', 'Admin supprimé');
		header('location:index.php?module=admin_users');exit();
	}
	else {
		create_notice('danger', 'Suppression impossible !');
		header('location:index.php?module=admin_users');exit();
	}
}

if(isset($_POST['action']) && $_POST['action'] == "send_mail") {
	
	$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.header.htm');
	$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.contact.htm');
	$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.footer.htm');
	
	// On remplace les infos personnelles
	/*$tpl = str_replace("%PRENOM%", 		stripslashes($_POST['contact_prenom']), 		$tpl);
	$tpl = str_replace("%NOM%",			stripslashes($_POST['contact_nom']), 			$tpl);
	$tpl = str_replace("%TELEPHONE%", 	$_POST['contact_telephone'], 					$tpl);
	$tpl = str_replace("%MAIL%", 		$_POST['contact_mail'], 						$tpl);
	$tpl = str_replace("%SOCIETE%", 	$_POST['contact_societe'], 						$tpl);
	$tpl = str_replace("%MESSAGE%", 	nl2br(stripslashes($_POST['contact_message'])), $tpl);
	$tpl = str_replace("%SITE_NAME%", 	$config->site_name, 							$tpl);
	$tpl = str_replace("%SITE_URL%",	$config->site_url, 								$tpl);
	$tpl = str_replace("%LOGO_URL%", 	$config->site_url . '/images/logo-mail.jpg', 	$tpl);*/



	if(send_mail($tpl, $_SESSION['ADMIN-USER']['firstname'], $_SESSION['ADMIN-USER']['name'], $_SESSION['ADMIN-USER']['mail'], $_POST['input_mail'], $_POST['subject'])) {
		create_notice('success', 'Message envoyé');
		header('location:index.php?module=admin_users');exit();
	}
}


##############################################################
##	APPEL TOOLS												##
##############################################################
$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
$styles_to_load = array("style");

##############################################################
##	VARIABLES LAYOUT										##
##############################################################
DEFINE("_METATITLE", "Admin users");
DEFINE("_METADESCRIPTION", "Admin users");

##############################################################
##	VUE														##
##############################################################
include_once('../app/views/admin_admin_users/display.php');


?>