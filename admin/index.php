<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
	
##############################################################
##	CHEMINS													##
##############################################################
DEFINE('_ADMIN_PATH', '');
DEFINE('_APP_PATH', '../app/');
DEFINE('_WWW_PATH', '../www/');

##############################################################
##	INIT													##
##############################################################
require_once(_APP_PATH . 'config/admin_init.php');

require_once _APP_PATH . 'models/class.notices.php';
$notices = new classNotices();

session_name(_SES_NAME);

//Dispatching des modules
if (isset($_GET['module'])) 
{
	$class = $_GET["module"].'Controller';
	$module = 'admin_'.$_GET["module"];
}
else 
{
	//Module par défaut
	$class = 'indexController';
	$module = 'admin_index';
}
include_once _APP_PATH . 'app.php';
?>