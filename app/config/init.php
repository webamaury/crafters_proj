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
DEFINE('_SITE_NAME', 'Crafters');
DEFINE('_SES_NAME', 'Crafters');
DEFINE('_COOKIE_NAME', 'CraftersCookie');


/**
 *	RECUPERATION DE LA PAGE ACTUELLE
 */

$currentPage = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

/**
 *	CHARGEMENT DES TABLEAUX TOOLS
 */

require_once(_WWW_PATH . 'tools/array/array.tools.php');

/**
 *	APPELS CLASS
 */
require_once(_APP_PATH . 'models/class.session.php'); $session = new Session();
require_once (_APP_PATH . 'models/class.notices.php'); $notices = new ClassNotices();

require_once(_CORE_PATH . 'coreViews.php');
require_once(_CORE_PATH . 'coreModel.php');
require_once(_CORE_PATH . 'coreController.php'); $coreControler = new CoreController();

require_once(_APP_PATH . 'models/lib.function.php');

require_once(_APP_PATH . 'models/class.users.php'); $user = new ClassUsers();
//var_dump($_SESSION[_SES_NAME]);

/**
 * TEST DE WAITING PAGE
 */
if (date('Y-m-d H:i:s') < '2015-03-01 23:59:59' ) {
	include_once(_APP_PATH . 'controllers/autres/autres.php');
	$_POST['action'] = 'wait';
	$autresController = new AutreController($arrayCss, $arrayJs, $notices);

	exit();
}

/**
 * TEST STANDBY
 */
if (isset($config) && !empty($config) && $config->standby == 'true') {
	include_once(_APP_PATH . 'controllers/autres/autres.php');
	$_POST['action'] = 'standby';
	$autresController = new AutreController($arrayCss, $arrayJs, $notices);

	exit();
}

/**
 * Suppression message page
 */
if(isset($_SESSION[_SES_NAME]['pageMessage'])) {
	if (isset($_GET['module']) && isset($_GET['action']) && $_GET['module'] == 'autre' && $_GET['action'] == 'messagePage') {

	} else {
		unset($_SESSION[_SES_NAME]['pageMessage']);
	}
}

/**
 * VERIF COOKIE CNIL
 */
if (!isset($_COOKIE['CraftersCnil']) || $_COOKIE['CraftersCnil'] != 1) {
	DEFINE('_CNIL', false);
} else {
	DEFINE('_CNIL', true);
}

/**
 *  OUVERTURE DE SESSION
 */
if ((isset($_POST['action']) && $_POST['action'] === 'login')) {
	
	$user->mail = $_POST['email'];
	$user->password = md5($_POST['password']);
	if (isset($_POST['remember'])) {
		$user->remember = $_POST['remember'];
	} else {
		$user->remember = 0;
	}

	$return = $user->login();
	if ($return === 'error0' || $return === 'error1') {
		sleep(1);
		$notices->createNotice('danger', 'Error username/password');
		header('Location: index.php');
		exit();
	} else if ($return === 'error2') {
		sleep(1);
		$notices->createNotice('danger', 'Invalid accound, please check your e-mail to validate.');
		header('Location: index.php');
		exit();
	} else {
		if ($user->isAuthed()) {
			if ($user->remember == true) {
				$values = json_encode(array('user' => $_POST['email'], 'pwd' => md5($_POST['password'])));
				$coreControler->cookieRemenberMe($values);
			}
			$notices->createNotice('success', 'Hello ' . $_SESSION[_SES_NAME]['username'] . ', welcome on crafters');
			header('Location: ' . $currentPage);
			exit();
		}
	}
}

/**
 * FERMETURE DE SESSION
 */
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
	$user->logout();
	$coreControler->removeCookie();
	header('Location: index.php');
	exit();
}
/**
 * TEST DE SESSION
 */
$pagesAllowedWithoutSession = array(
	_PATH_FOLDER,
	_PATH_FOLDER . 'index.php',
	_PATH_FOLDER . 'gallery',
	_PATH_FOLDER . 'home',
	_PATH_FOLDER . 'profile',
	'index', 'fiche', 'profile', 'contact', 'panier', 'signup', 'gallery', 'autre');
if (isset($_GET['module'])) {
	$var = $_GET['module'];
} else {
	$var = $currentPage;
}

if (!$user->isAuthed() && !in_array($var, $pagesAllowedWithoutSession)) {
	$notices->createNotice("danger", "You must be connected to access to this page");
	header('Location: index.php?module=index');
	exit();
}
/**
 * TEST DE COOKIE
 */
if (!$user->isAuthed()) {
	if (isset($_COOKIE[_COOKIE_NAME])) {
		$values = json_decode($_COOKIE[_COOKIE_NAME]);
		$user->mail = $values->user;
		$user->password = $values->pwd;

		$return = $user->login();
		if ($return === 'error0' || $return === 'error1') {
			sleep(1);
			$notices->createNotice('danger', 'Error username/password');
			header('Location: index.php');
			exit();
		} else if ($return === 'error2') {
			sleep(1);
			$notices->createNotice('danger', 'Invalid accound, please check your e-mail to validate.');
			header('Location: index.php');
			exit();
		} else {
			if ($user->isAuthed()) {
				$notices->createNotice('success', 'Hello ' . $_SESSION[_SES_NAME]['username'] . ', welcome on crafters');
				header('Location: ' . $currentPage);
				exit();
			}
		}
	}
}

?>