<?php
##############################################################
##	TRAITEMENT PHP											##
##############################################################



/***********************************************************
 *	APPEL TOOLS											  **
 ***********************************************************/
$toolsToLoad = array("bootstrap-css", "jquery" , "bootstrap-js");
$stylesToLoad = array("style");

/***********************************************************
 *	VARIABLES LAYOUT									  **
 ***********************************************************/
 ***********************************************************/
DEFINE("_METATITLE", "Accueil Admin");
DEFINE("_METADESCRIPTION", "Accueil Admin");

/***********************************************************
 *	VUE													  **
 ***********************************************************/
include_once('../app/views/admin_index/display.php');


?>