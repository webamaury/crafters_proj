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

session_name(_SES_NAME);

//Dispatching des modules
if (isset($_GET['module'])) 
{
	$module = $_GET["module"];
}
else 
{
	//Module par défaut
	$module = 'index';
}
//Dispatching des actions
if (isset($_GET['display'])) 
{
	$display = $_GET["display"];
}
else 
{
	//Action par défaut
	$display = 'index';
}
//Constitution de l'URL
$url = '../app/controlers/admin_'.$module.'/'.$display.'.php';
//Dispatching vers controleur / action ou bien redirection 404
if (file_exists($url)) 
{
	include_once($url);
}
else
{
	include_once('../app/controlers/admin_autres/404.php');
}

?>