<?php
class CoreModels {
	
	protected $connexion ;
	protected $query;

	function __construct($bdd_host = _DB_HOST, $bdd_port = _DB_PORT, $bdd_name = _DB_NAME, $bdd_user = _DB_USER, $bdd_pass = _DB_PASS) {
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
	
	function get_array_from_query($sql, $mail, $password, $debug = false) {
	
		if($debug === true) echo "<p>".$sql."<p>";
		
		$query = $this->sql_query($sql, $mail, $password);
	
		return $query ;
		/*while($result = mysql_fetch_assoc($query)) {
			$data[] = $result;
		}
		return $data;*/
	}

	function sql_query($sql, $mail, $password, $debug = false) {
		
		if($debug === true) echo "<p>".$sql."<p>";

		$cursor = $this->connexion->prepare($sql);
		$cursor->bindValue(":mail", $mail, PDO::PARAM_STR);
		$cursor->bindValue(":mdp", $password, PDO::PARAM_STR);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
		return $return;	
	
	
		
		//$query = mysql_query($sql, $link_identifier) or die(mysql_error());
		//return $query;
	}
	
	function select_no_param() {
		$debug = false;
		if($debug === true) echo "<p>".$this->query."<p>";	
	
		$cursor = $this->connexion->prepare($this->query);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
		if($debug === true) var_dump($return);
		return $return;	
	}
	function select_one_with_one_param($query, $values, $champs = ':id', $debug = false) {
		if($debug === true) echo "<p>".$query."<p>";	
	
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue($champs, $values, PDO::PARAM_INT);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}
}
?>