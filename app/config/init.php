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
require_once(_CORE_PATH . 'coreModels.php');
require_once(_CORE_PATH . 'coreControlers.php'); new CoreControlers();
require_once(_APP_PATH . 'models/lib.function.php');

?>