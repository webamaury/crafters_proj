<?php
/***********************************************************
 *	TRAITEMENT PHP										  **
 ***********************************************************/

/***********************************************************
 *	APPEL TOOLS											  **
 ***********************************************************/
$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
$stylesToLoad = array("style");

/***********************************************************
 *	VARIABLES LAYOUT									  **
 ***********************************************************/

DEFINE("_METATITLE", "Admin 404");
DEFINE("_METADESCRIPTION", "Admin 404");

/***********************************************************
 *	VUE													  **
 ***********************************************************/
include_once('../app/views/admin_autres/404.php');

?>