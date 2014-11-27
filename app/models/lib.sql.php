<?php
require_once(_APP_PATH . 'models/connect.php');

function connection($bdd_host, $bdd_port, $bdd_name, $bdd_user, $bdd_pass) {
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

function sql_query($sql, $mail, $password, $debug = false) {
	
	if($debug === true) echo "<p>".$sql."<p>";
	
	global $connexion;


	$cursor = $connexion->prepare($sql);
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

function get_array_from_query($sql, $mail, $password, $debug = false) {
	
	if($debug === true) echo "<p>".$sql."<p>";
	
	$query = sql_query($sql, $mail, $password);

	return $query ;
	/*while($result = mysql_fetch_assoc($query)) {
		$data[] = $result;
	}
	return $data;*/
}

function select_no_param($query, $debug = false) {
	if($debug === true) echo "<p>".$query."<p>";
	
	global $connexion;


	$cursor = $connexion->prepare($query);

	$cursor->execute();

	$cursor->setFetchMode(PDO::FETCH_OBJ);		
	$return=$cursor->fetchAll();
	$cursor->closeCursor();
	if($debug === true) var_dump($return);
	return $return;	
}

function select_param($query, $champs, $values, $debug = false) {
	if($debug === true) echo "<p>".$query."<p>";

	global $connexion;


	$cursor = $connexion->prepare($query);

	$cursor->bindValue($champs, $values, PDO::PARAM_INT);

	$cursor->execute();

	$cursor->setFetchMode(PDO::FETCH_OBJ);		
	$return=$cursor->fetchAll();
	$cursor->closeCursor();

	return $return[0] ;	
}































?>