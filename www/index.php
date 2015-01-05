<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

##############################################################
##	CHEMINS													##
##############################################################
DEFINE('_APP_PATH', '../app/');
DEFINE('_WWW_PATH', '');
DEFINE('_CORE_PATH', '../core/');
DEFINE('_ADMIN_PATH', '../admin/');


##############################################################
##	INIT													##
##############################################################
require_once(_APP_PATH . 'config/init.php');


//Dispatching des modules
if (isset($_GET['module'])) 
{
	$class = $_GET["module"].'Controller';
	$module = $_GET["module"];
}
else 
{
	//Module par défaut
	$class = 'indexController';
	$module = 'index';
}
include_once _APP_PATH . 'app_front.php';
?>