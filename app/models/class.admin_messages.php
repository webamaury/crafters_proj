<?php
//parent::__construct()
class classMessages extends CoreModels {
		
	function get_one() {
		$query = "SELECT U.id, U.firstname, U.name, U.mail, U.phone, S.nom, S.statut FROM " . _TABLE__ADMIN_USERS . " as U," . _TABLE__ADMIN_STATUTS . " as S WHERE U.id = :id AND S.type = 'admin' AND S.statut = U.statut";
	
		$champs = ':id';
		$values = $this->id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}
	function get_one_array() {
		$query = "SELECT U.id, U.firstname, U.name, U.mail, U.phone, S.nom FROM " . _TABLE__ADMIN_USERS . " as U," . _TABLE__ADMIN_STATUTS . " as S WHERE U.id = :id AND S.type = 'admin' AND S.statut = U.statut";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}
	function get_list() {
		$orderby = 'message_id asc';
		$this->query = "SELECT message_id, message_firstname, message_name, message_mail FROM " . _TABLE__MESSAGE . " ORDER BY " . $orderby;
		$list = $this->select_no_param();
				
		return $list ;
	}
	
	
	function delete_admin() {
		$admin = $this->get_one();
	
		if($_SESSION['ADMIN-USER']['statut'] = 1) {
			$query = "DELETE FROM nomduprojet_admin_users WHERE id = :id";
				
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true ;
		}
	}
	

	function get_statuts() {
		$query = "SELECT * FROM " . _TABLE__ADMIN_STATUTS . " WHERE type = 'message'";
	
		$list = $this->select_no_param($query);
	
		return $list ;
	}

}
?>