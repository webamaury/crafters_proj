<?php
##############################################################
##	CHARGEMENT DES FICHIERS DE CONF							##
##############################################################
require_once(_APP_PATH . 'models/connect.php');
require_once(_APP_PATH . 'models/config.php');

##############################################################
##	NOM DE SESSION						##
##############################################################
DEFINE('_SES_NAME', 'nomduprojet');

##############################################################
##	RECUPERATION DE LA PAGE ACTUELLE						##
##############################################################
$current_page = basename($_SERVER['SCRIPT_FILENAME']);

##############################################################
##	CHARGEMENT DES TABLEAUX TOOLS							##
##############################################################
require_once(_WWW_PATH . 'tools/array/array.tools.php');

##############################################################
##	APPELS CLASS											##
##############################################################
require_once(_APP_PATH . 'models/class.sql.php'); $sql = new Sql(); 
require_once(_APP_PATH . 'models/class.session.php'); $session = new Session(); 

//var_dump($_COOKIE);

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

##############################################################
## OUVERTURE DE SESSION										##
##############################################################
if ((isset($_POST['action']) && $_POST['action'] == 'login') || (isset($_POST['subaction']) && $_POST['subaction'] == 'login'))
{
	$session->attempt_login($_POST['mail'], md5($_POST['password']));
	if ($session->is_authed())
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		
		header('Location: index.php?module=login');
		exit();
	}
}

##############################################################
## FERMETURE DE SESSION										##
##############################################################
if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$session->destroy_session();
	header('Location: index.php');
	exit();
}
*/
?>	