<?php
	require_once(_APP_PATH . "models/connect.php");
	
	class CoreModels {
		
		protected $connexion ;
		
		function __construct() {
			try
			{
				$this->connexion = new PDO ('mysql:host='.$bdd_host.';port='.$bdd_port.';dbname='.$bdd_name, $bdd_user, $bdd_pass);
				$this->connexion->exec("SET CHARACTER SET utf8");
			}
			catch(Exeption $e)
			{
				echo 'Erreur : '.$e->getMessage().'<br />';
				echo 'N° : '.$e->getCode();	
			}		
		}
		
	}
	
?>