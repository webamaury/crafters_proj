<?php
//parent::__construct()
class classUsers extends CoreModels {

	function get_one() {
		$query = "SELECT U.user_id, U.user_firstname, U.user_name, U.user_mail, U.user_birthday, U.user_phone, U.user_creation, S.nom, S.statut FROM " . _TABLE__USERS . " as U," . _TABLE__STATUTS . " as S WHERE U.user_id = :id AND S.type = 'user' AND S.statut = U.user_status";
	
		$champs = ':id';
		$values = $this->user_id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}
	function get_one_array() {
		$query = "SELECT U.user_id, U.user_firstname, U.user_name, U.user_mail, U.user_birthday, U.user_phone, U.user_creation, S.nom FROM " . _TABLE__USERS . " as U," . _TABLE__STATUTS . " as S WHERE U.user_id = :id AND S.type = 'user' AND S.statut = U.user_status";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}
	function get_list() {
		$orderby = 'user_id asc';
		$this->query = "SELECT user_id, user_firstname, user_name, user_mail FROM " . _TABLE__USERS . " ORDER BY " . $orderby;
			
		$list = $this->select_no_param();
		
		return $list ;
	}
	
	function create_admin() {
		$query = "INSERT INTO " . _TABLE__ADMIN_USERS . " 
		(mail, password, firstname, name, phone, statut) 
		VALUES 
		(:mail, :password, :firstname, :name, :phone, :statut)";
		
		$cursor = $this->connexion->prepare($this->query);
	
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
	
	function delete_user() {
	
			$query = "DELETE FROM " . _TABLE__USERS . " WHERE user_id = :id";
				
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true ;
	}
	
	function update_user() {
		$query = "UPDATE " . _TABLE__USERS . " 
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

	function get_statuts() {
		$query = "SELECT * FROM " . _TABLE__STATUTS . " WHERE type = 'user'";
	
		$cursor = $this->connexion->prepare($query);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list=$cursor->fetchAll();
		$cursor->closeCursor();

		return $list ;
	}

}
?>