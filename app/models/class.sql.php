<?php
require_once(_APP_PATH . 'models/connect.php');
class Sql {


	public function __construct($bdd_host = _DB_HOST, $bdd_port = _DB_PORT, $bdd_name = _DB_NAME, $bdd_user = _DB_USER, $bdd_pass = _DB_PASS) {
		Sql::connection($bdd_host, $bdd_port, $bdd_name, $bdd_user, $bdd_pass);

	}
	public function connection($bdd_host, $bdd_port, $bdd_name, $bdd_user, $bdd_pass) {
		try
		{
			$connexion = new PDO ('mysql:host='.$bdd_host.';port='.$bdd_port.';dbname='.$bdd_name, $bdd_user, $bdd_pass);
			$connexion->exec("SET CHARACTER SET utf8");
		}
		catch(Exeption $e)
		{
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();	
		}		
	}
	
	##################################################################
	##																##
	## [F001]	SQL METHODS											##
	##																##
	##################################################################
	public function get_login($sql, $mail, $password) {
echo $sql;

		global $connexion;

		$query = $sql;
		
					
		$cursor = $connexion->prepare($query);
		$cursor->bindValue(":id", $mail, PDO::PARAM_INT);
		$cursor->bindValue(":mdp", $password, PDO::PARAM_STR);
		
		$cursor->execute();
		
		
		if($cursor->rowCount()==1)
		{
			$cursor->setFetchMode(PDO::FETCH_OBJ);		
			$return=$cursor->fetch();
			$cursor->closeCursor();
			return $return;	
		}
		else
		{
			return false;		//Contact inconnu
		}

	}


	// Soumet une requete
	public static function sql_query($sql, $debug = true) {
		
		if($debug === true) echo "<p>".$sql."<p>";
		
		global $connexion;

		$cursor = $connexion->prepare($sql);
		
		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return=$cursor->fetchAll();
		$cursor->closeCursor();

		return $return;	


		
		//$query = mysql_query($sql, $link_identifier) or die(mysql_error());
		//return $query;
	}

	// Retourne un tableau de données
	public static function get_array_from_query($sql, $debug = false) {
		
		if($debug === true) echo "<p>".$sql."<p>";
		
		$query = Sql::sql_query($sql) or die();
		/*$data = array();
		while($result = mysql_fetch_assoc($query)) {
			$data[] = $result;
		}
		return $data;*/
	}
/*
	// Retourne une liste d'objets
	public static function get_objects_from_query($sql, $class_name, $link_identifier = CONNECTION, $debug = false) {
		
		if($debug === true) echo "<p>".$sql."<p>";
		
		$query = Sql::sql_query($sql, $link_identifier) or die(mysql_error());
		$data = array();
		while($result = mysql_fetch_object($query, $class_name)) {
			$data[] = $result;
		}
		return $data;
	}

	// Retourne une ligne de donnees
	public static function get_row_from_query($sql, $link_identifier = CONNECTION, $debug = false) {
		
		if($debug === true) echo "<p>".$sql."<p>";
		
		$query = Sql::sql_query($sql, $link_identifier) or die(mysql_error());
		$data = array();
		while($result = mysql_fetch_assoc($query)) {
			$data[] = $result;
		}
		
		if(!empty($data[0])) {
			return $data[0];
		}
		else {
			return array();
		}
	}

	// Retourne une valeur unique
	public static function get_value_from_query($sql, $link_identifier = CONNECTION, $debug = false) {
		
		if($debug === true) echo "<p>".$sql."<p>";
		
		$query = Sql::sql_query($sql, $link_identifier) or die(mysql_error());
		$result = mysql_fetch_array($query);
		return $result[0];
	}

	// Retourne un tableau d'une ligne
	public static function get_field_array_from_query($sql, $link_identifier = CONNECTION, $debug = false) {
		
		if($debug === true) echo "<p>".$sql."<p>";
		
		$query = Sql::sql_query($sql, $link_identifier) or die(mysql_error());
		
		$results = array();
		
		while($result = mysql_fetch_array($query)) {
		
			if(!empty($result)) {
				$results[] = $result[0];
			}
			
		}

		return $results;
	}
	*/


}
?>