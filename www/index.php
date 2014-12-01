<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
	
##############################################################
##	CHEMINS													##
##############################################################
DEFINE('_APP_PATH', '../app/');
DEFINE('_WWW_PATH', '');
DEFINE('_ADMIN_PATH', _APP_PATH.'../admin/');

##############################################################
##	INIT													##
##############################################################
require_once(_APP_PATH . 'config/init.php');

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
/*if (isset($_GET['action'])) 
{
	$action = $_GET["action"];
}
else 
{
	//Action par défaut
	$action = 'index';
}*/
//Constitution de l'URL
$url = '../app/controlers/'.$module.'/index.php';
//Dispatching vers controleur / action ou bien redirection 404
if (file_exists($url)) 
{
	include_once($url);
}
else
{
	include_once('../app/views/autres/404.php');
}

?>