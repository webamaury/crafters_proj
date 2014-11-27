<?php
##############################################################
##	CHARGEMENT DES FICHIERS DE CONF							##
##############################################################
require_once(_APP_PATH . 'models/connect.php');
require_once(_APP_PATH . 'models/config.php');

##############################################################
##	NOM DE SESSION						##
##############################################################
DEFINE('_SES_NAME', 'nomduprojet_admin');

##############################################################
##	RECUPERATION DE LA PAGE ACTUELLE						##
##############################################################
$current_page = basename($_SERVER['REQUEST_URI']);

##############################################################
##	CHARGEMENT DES TABLEAUX TOOLS							##
##############################################################
require_once(_WWW_PATH . 'tools/array/array.tools.php');

##############################################################
##	APPELS CLASS											##
##############################################################
$connexion = new PDO ('mysql:host='._DB_HOST.';port='._DB_PORT.';dbname='._DB_NAME, _DB_USER, _DB_PASS);
$connexion->exec("SET CHARACTER SET utf8");

require_once(_APP_PATH . 'models/lib.sql.php'); //connection(_DB_HOST, _DB_PORT, _DB_NAME, _DB_USER, _DB_PASS); 
require_once(_APP_PATH . 'models/lib.session.php'); session(); 
require_once(_APP_PATH . 'models/lib.function.php'); 

//var_dump($_COOKIE);

##############################################################
## RECUPERATION DES MODULES									##
##############################################################
$modules = load_modules();
/*
##############################################################
## GESTION DE LA MAINTENANCE								##
##############################################################
if ($config->site_maintenance == 1 && $current_page != 'index.php?module=maintenance')
{
	header('Location: index.php?module=maintenance');
	exit();
}
elseif ($config->site_maintenance == 0 && $current_page == 'index.php?module=maintenance')
{
	header('Location: index.php');
	exit();
}
*/
##############################################################
## OUVERTURE DE SESSION										##
##############################################################
if ((isset($_POST['action']) && $_POST['action'] == 'login') || (isset($_POST['subaction']) && $_POST['subaction'] == 'login'))
{
	attempt_admin_login($_POST['mail'], md5($_POST['password']));

	if (is_admin_authed())
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		create_notice('danger', 'Erreur login / mot de passe');
		header('Location: index.php?module=login');
		exit();
	}
}

##############################################################
## FERMETURE DE SESSION										##
##############################################################
if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	destroy_admin_session();
	header('Location: index.php');
	exit();
}

##############################################################
## TEST DE SESSION											##
##############################################################
$pages_allowed_without_session = array('index.php?module=login', 'password.retrieve.php' );
if (!is_admin_authed() && !in_array( $current_page, $pages_allowed_without_session))
{
	header('Location: index.php?module=login');
	exit();
}

?>