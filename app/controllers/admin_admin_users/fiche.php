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
	if(update_admin($_POST['mail'], $_POST['firstname'], $_POST['name'], $_POST['phone'])) {
		create_notice('success', 'User modifié');
		header('location:'.$current_page);exit();
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
include_once('../app/views/admin_admin_users/fiche.php');

?>