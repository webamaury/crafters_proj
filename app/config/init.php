<?php
##############################################################
##	CHARGEMENT DES FICHIERS DE CONF							##
##############################################################
require_once(_APP_PATH . 'models/connect.php');
require_once(_APP_PATH . 'models/config.php');

##############################################################
##	NOM DE SESSION						##
##############################################################
DEFINE('_SES_NAME', 'Crafters');
DEFINE('_SITE_NAME', 'Crafters');

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
require_once _APP_PATH . 'models/class.notices.php'; $notices = new classNotices();
require_once(_APP_PATH . 'models/class.session.php'); $session = new Session();
require_once(_CORE_PATH . 'coreModels.php');
require_once(_CORE_PATH . 'coreControlers.php'); new CoreControlers();
require_once(_APP_PATH . 'models/lib.function.php');
require_once(_APP_PATH . 'models/class.users.php'); $user = new classUsers();

##############################################################
## OUVERTURE DE SESSION										##
##############################################################
if ((isset($_POST['action']) && $_POST['action'] == 'login'))
{
	
	$user->mail = $_POST['email'];
	$user->password = md5($_POST['password']);
		
	$user->login();

	if ($user->is_authed())
	{
		header('Location: '.$current_page);
		exit();
	}
	else
	{
		create_notice('danger', 'Erreur login / mot de passe');
		header('Location: index.php');
		exit();
	}
}

##############################################################
## FERMETURE DE SESSION										##
##############################################################
if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$user->logout();
	header('Location: index.php');
	exit();
}
##############################################################
## TEST DE SESSION											##
##############################################################
$pages_allowed_without_session = array('www', 'index.php', 'index', 'fiche', 'profil', 'contact');
if(isset($_GET['module'])){ $var = $_GET['module'] ; }
else{ $var = $current_page ; }
if (!$user->is_authed() && !in_array( $var , $pages_allowed_without_session))
{
	header('Location: index.php?module=index');
	exit();
}
?>