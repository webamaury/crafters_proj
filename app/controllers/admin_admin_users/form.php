<?php
##############################################################
##	TRAITEMENT PHP											##
##############################################################
include_once(_APP_PATH . 'models/lib.admin_users.php');

if(isset($_GET['id'])){ 
	$item = get_one($_GET['id']);
}
$statuts = get_statuts();

if(isset($_POST['action']) && $_POST['action'] == 'modifier') {
	if(update_admin($_POST['mail'], $_POST['firstname'], $_POST['name'], $_POST['phone'], $_GET['id'])) {
		create_notice('success', 'User modifié');
		header('location:'.$current_page);exit();
	}
	else {
		create_notice('danger', 'Erreur');
		header('location:'.$current_page);exit();
	}
}
else if(isset($_POST['action']) && $_POST['action'] == 'ajouter') {
	if(create_admin($_POST['mail'], $_POST['firstname'], $_POST['name'], $_POST['phone'], $_POST['statut'])) {
		create_notice('success', 'User ajouté');
		echo 'true';
		//header('location:index.php?module=admin_users');exit();
	}
	else {
		create_notice('danger', 'Erreur insert');

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
include_once('../app/views/admin_admin_users/form.php');

?>