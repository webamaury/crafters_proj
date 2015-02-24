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
	'name' 					=> 'Products', 
	'description' 			=> 'Manage products',
	'icon' 					=> 'glyphicon-fire', 
	'path' 					=> 'products', 
	'allowed_levels' 		=> array(1, 2), 
	'position' 				=> 3
);
?>