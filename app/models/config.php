<?php
##############################################################
##	PREFIXE DES TABLES										##
##############################################################
DEFINE( '_DB_PREFIX', 'crafters_' );


##############################################################
##	TABLES													##
##############################################################
DEFINE( '_TABLE_CONTACT', 						_DB_PREFIX."contact" );
DEFINE( '_TABLE__ADMIN_USERS', 					_DB_PREFIX."admin_users");
DEFINE( '_TABLE__USERS', 						_DB_PREFIX."user");
DEFINE( '_TABLE__ADDRESS', 						_DB_PREFIX."address");
DEFINE( '_TABLE__PRODUCTS', 					_DB_PREFIX."product");
DEFINE( '_TABLE__MESSAGE',		 				_DB_PREFIX."message" );
DEFINE( '_TABLE__STATUTS', 						_DB_PREFIX."statuts");
DEFINE( '_TABLE__LIKE', 						_DB_PREFIX."like");
DEFINE( '_TABLE__COMMANDES', 					_DB_PREFIX."order");
DEFINE( '_TABLE__COMMANDES_PRODUITS',			_DB_PREFIX."product_order");

DEFINE( '_TABLE__ORDER', 						_DB_PREFIX."order");
DEFINE( '_TABLE__PRODUCT_ORDER', 				_DB_PREFIX."product_order");

?>