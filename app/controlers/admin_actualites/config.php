<?php
##############################################################################
## FICHIER DE CONFIG DU MODULE												##
##																			##
## name : le nom affiché dans le menu										##
## path : le chemin d'accès au module										##
## allowed_levels : niveaux d'utilisateur autorisés à accéder au module ;	##
##	1 = administrateur														##
##	2 = salarié																##
##############################################################################

$module_details = array(
	'name' 					=> 'Actualités', 
	'description' 			=> 'Gestion des actus',
	'icon' 					=> 'glyphicon-paperclip', 
	'path' 					=> 'actualites', 
	'allowed_levels' 		=> array(1, 2), 
	'position' 				=> 3
);
?>