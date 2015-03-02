<?php
//parent::__construct()
class classAdminUsers extends CoreModel {
		
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
				$_SESSION["ADMIN-USER"]["img_url"] 		= $accounts[0]->admin_img_url;
				$_SESSION["ADMIN-USER"]["statut"] 		= $accounts[0]->statut;
	
				return true;
			}
			else {
				return false;
			}
			
		}
		
	}
	function isAuthed() {
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
	
	function getOne() {
		$query = "SELECT U.id,
			U.firstname,
			U.name,
			U.mail,
			U.phone,
			U.admin_img_url,
			S.nom,
			S.statut
			FROM " . _TABLE__ADMIN_USERS . " as U," . _TABLE__STATUTS . " as S
			WHERE U.id = :id AND S.type = 'admin' AND S.statut = U.statut";
	
		$champs = ':id';
		$values = $this->id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}
	function get_one_array() {
		$query = "SELECT U.id, U.firstname, U.name, U.mail, U.phone, U.admin_img_url, S.nom FROM " . _TABLE__ADMIN_USERS . " as U," . _TABLE__STATUTS . " as S WHERE U.id = :id AND S.type = 'admin' AND S.statut = U.statut";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0];
	}
	function get_list() {
		$orderby = 'id asc';
		$this->query = "SELECT U.id, U.firstname, U.name, U.mail, S.nom
			FROM " . _TABLE__ADMIN_USERS . " as U, " . _TABLE__STATUTS . " as S
			WHERE S.statut = U.statut
			AND S.type = 'admin'
			ORDER BY " . $orderby;
			
		$list = $this->select_no_param();
		
		return $list;
	}
	/**
	 * @param $image_url
	 * @param $admin
	 * @return bool
	 */
	function updateImage($image_url, $admin)
	{
		$query = "UPDATE " . _TABLE__ADMIN_USERS . "
		SET admin_img_url = :admin_img_url
		WHERE id = :id";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':admin_img_url', $image_url, PDO::PARAM_STR);
		$cursor->bindValue(':id', $admin, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}

	function create_admin() {
		$query = "INSERT INTO " . _TABLE__ADMIN_USERS . " 
		(mail, password, firstname, name, phone, statut) 
		VALUES 
		(:mail, :password, :firstname, :name, :phone, :statut)";

		$cursor = $this->connexion->prepare($query);
	
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
		$admin = $this->getOne();
	
		if ($_SESSION['ADMIN-USER']['statut'] = 1) {
			$query = "DELETE FROM " . _TABLE__ADMIN_USERS . " WHERE id = :id";
				
			$cursor = $this->connexion->prepare($query);
	
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
					
		$cursor = $this->connexion->prepare($query);
			
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
			
		$cursor = $this->connexion->prepare($query);
			
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
		$query = "SELECT * FROM " . _TABLE__STATUTS . " WHERE type = 'admin'";

		$cursor = $this->connexion->prepare($query);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}

}
?>