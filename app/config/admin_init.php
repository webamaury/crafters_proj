<?php
/**
 *	CHARGEMENT DES FICHIERS DE CONF
 */
$jsonConfig = file_get_contents(_APP_PATH . 'controllers/admin_config/file.json');
$config = json_decode($jsonConfig);

require_once(_APP_PATH . 'models/connect.php');
require_once(_APP_PATH . 'models/config.php');

/**
 *	NOM DE SESSION
 */
DEFINE('_SES_NAME', 'Crafters_Admin');
DEFINE('_SITE_NAME', 'Crafters Admin');

/**
 *	RECUPERATION DE LA PAGE ACTUELLE
*/
$currentPage = basename($_SERVER['REQUEST_URI']);

/**
 *	CHARGEMENT DES TABLEAUX TOOLS
*/
require_once(_WWW_PATH . 'tools/array/array.tools.php');

/**
 *	APPELS CLASS
*/

//require_once(_APP_PATH . 'models/lib.sql.php'); //connection(_DB_HOST, _DB_PORT, _DB_NAME, _DB_USER, _DB_PASS); 
require_once(_APP_PATH . 'models/class.session.php'); $session = new Session();
require_once(_CORE_PATH . 'coreController.php'); new CoreController();
require_once(_CORE_PATH . 'coreModel.php');
require_once(_APP_PATH . 'models/lib.function.php');
require_once (_APP_PATH . 'models/class.notices.php'); $notices = new ClassNotices();
require_once(_APP_PATH . 'models/class.adminUsers.php'); $user = new classAdminUsers();
//var_dump($_COOKIE);

/**
 * RECUPERATION DES MODULES
 */
$modules = load_modules();

/**
 * GESTION DE LA MAINTENANCE
 */
/*
if ($config->site_maintenance === 1 && $currentPage !== 'index.php?module=maintenance') {
	header('Location: index.php?module=maintenance');
	exit();
} elseif ($config->site_maintenance === 0 && $currentPage === 'index.php?module=maintenance') {
	header('Location: index.php');
	exit();
}
*/
/**
 * OUVERTURE DE SESSION
 */
if ((isset($_POST['action']) && $_POST['action'] === 'login') || (isset($_POST['subaction']) && $_POST['subaction'] === 'login')) {
	
	$user->mail = $_POST['mail'];
	$user->password = md5($_POST['password']);
	
	$user->login();

	if ($user->isAuthed()) {
		header('Location: index.php');
		exit();
	} else {
		$notices->createNotice('danger', 'Erreur login / mot de passe');

		sleep(2);
		header('Location: index.php?module=login');
		exit();
	}
}

/**
 * FERMETURE DE SESSION
 */
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
	$user->logout();
	header('Location: index.php');
	exit();
}

/**
 * TEST DE SESSION
 */
$pagesAllowedWithoutSession = array('index.php?module=login');
if (!$user->isAuthed() && !in_array($currentPage, $pagesAllowedWithoutSession)) {
	header('Location: index.php?module=login');
	exit();
}

?>