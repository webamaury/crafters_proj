<?php
include_once _APP_PATH . 'models/class.sql.php';

class classAdminUsers extends classSql {
	
	function __construct() {
	}
	
	function login() {

		$accounts = $this->get_array_from_query("SELECT * FROM " . _TABLE__ADMIN_USERS . " WHERE mail = :mail AND password = :mdp", 
		$this->mail, $this->password);
		
		// No account found
		if(sizeof($accounts) == 0) {
			//$notice = new Notice('failure', 'Aucun compte correspondant.');
			//$notice->sessionize();
			return false;
		}
		// More than one account found
		elseif(sizeof($accounts) > 1) {
			//$notice = new Notice('failure', 'Plus d\'un compte correspondant à ces identifiants.');
			//$notice->sessionize();
			return false;
		}
		// One account found - login
		else {
			
			if($accounts[0]->statut != 0) {
				$session_authed = true;
				
				$_SESSION["ADMIN-USER"]["authed"] 		= $session_authed;
				$_SESSION["ADMIN-USER"]["id"] 			= $accounts[0]->id;
				$_SESSION["ADMIN-USER"]["mail"] 		= $accounts[0]->mail;
				$_SESSION["ADMIN-USER"]["password"] 	= $accounts[0]->password;
				$_SESSION["ADMIN-USER"]["firstname"] 	= $accounts[0]->firstname;
				$_SESSION["ADMIN-USER"]["name"] 		= $accounts[0]->name;
				$_SESSION["ADMIN-USER"]["statut"] 		= $accounts[0]->statut;
	
				return true;
			}
			else {
				return false;
			}
			
		}
		
	}
	function is_authed() {
		if(isset($_SESSION["ADMIN-USER"]["authed"])) {
			return $_SESSION["ADMIN-USER"]["authed"];
		}
		else {
			return false;
		}
	}
	
	function logout() {
	    unset($_SESSION['ADMIN-USER']);
		
		//setcookie(COOKIE_NAME . "[admin_login]", '', time() - 3600);
		//setcookie(COOKIE_NAME . "[admin_password]", '', time() - 3600);
	}
	
	function get_one() {
		$query = "SELECT U.id, U.firstname, U.name, U.mail, U.phone, S.nom, S.statut FROM " . _TABLE__ADMIN_USERS . " as U," . _TABLE__ADMIN_STATUTS . " as S WHERE U.id = :id AND S.type = 'admin' AND S.statut = U.statut";
	
		$champs = ':id';
		$values = $this->id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}
	function get_one_array() {
		$query = "SELECT U.id, U.firstname, U.name, U.mail, U.phone, S.nom FROM " . _TABLE__ADMIN_USERS . " as U," . _TABLE__ADMIN_STATUTS . " as S WHERE U.id = :id AND S.type = 'admin' AND S.statut = U.statut";
	
		global $connexion;
	
	
		$cursor = $connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}
	function get_list($orderby = 'id asc') {
		$query = "SELECT id, firstname, name, mail FROM " . _TABLE__ADMIN_USERS . " ORDER BY " . $orderby;
			
		$list = $this->select_no_param($query);
		
		return $list ;
	}
	
	function create_admin() {
		$query = "INSERT INTO nomduprojet_admin_users 
		(mail, password, firstname, name, phone, statut) 
		VALUES 
		(:mail, :password, :firstname, :name, :phone, :statut)";
	
		global $connexion;
	
		$cursor = $connexion->prepare($query);
	
		$cursor->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$cursor->bindValue(':password', $this->password, PDO::PARAM_STR);
		$cursor->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
		$cursor->bindValue(':name', $this->name, PDO::PARAM_STR);
		$cursor->bindValue(':phone', $this->phone, PDO::PARAM_STR);
		$cursor->bindValue(':statut', $this->statut, PDO::PARAM_INT);
	
		$return = $cursor->execute();
		$cursor->closeCursor();
		return $return ;
	}
	
	function delete_admin() {
		$admin = $this->get_one();
	
		if($_SESSION['ADMIN-USER']['statut'] = 1) {
			$query = "DELETE FROM nomduprojet_admin_users WHERE id = :id";
			
			global $connexion;
	
			$cursor = $connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true ;
		}
	}
	
	function update_admin() {
		$query = "UPDATE " . _TABLE__ADMIN_USERS . " 
		SET mail = :mail,
		firstname = :firstname,
		name = :name,
		phone = :phone,
		statut = :statut 
		WHERE id = :id";
		
		global $connexion;
			
		$cursor = $connexion->prepare($query);
			
		$cursor->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$cursor->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
		$cursor->bindValue(':name', $this->name, PDO::PARAM_STR);
		$cursor->bindValue(':phone', $this->phone, PDO::PARAM_STR);
		$cursor->bindValue(':statut', $this->statut, PDO::PARAM_INT);
		$cursor->bindValue(':id', $this->id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return ;
	}
	function update_password() {
		$query = "UPDATE " . _TABLE__ADMIN_USERS . " 
		SET password = :password
		WHERE id = :id";

		global $connexion;
			
		$cursor = $connexion->prepare($query);
			
		$cursor->bindValue(':password', $this->password, PDO::PARAM_STR);
		$cursor->bindValue(':id', $this->id, PDO::PARAM_INT);

		$return = $cursor->execute();
		$cursor->closeCursor();
		if(empty($return)){
			return false;
		}
		else {
			return true;
		}
	}

	function get_statuts() {
		$query = "SELECT * FROM " . _TABLE__ADMIN_STATUTS . " WHERE type = 'admin'";
	
		$list = $this->select_no_param($query);
	
		return $list ;
	}

}
?>