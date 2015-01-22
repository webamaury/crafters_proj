<?php
//parent::__construct()
class classMessages extends CoreModels {
		
	function get_one() {
		$query = "SELECT M.message_id, M.message_firstname, M.message_name, M.message_mail, M.message_title, M.message_message, M.message_creation, S.nom, S.statut FROM " . _TABLE__MESSAGE . " as M," . _TABLE__STATUTS . " as S WHERE M.message_id = :id AND S.type = 'message' AND S.statut = M.message_status";
		
	
		$champs = ':id';
		$values = $this->message_id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}
	function get_one_array() {
		$query = "SELECT M.message_id, M.message_firstname, M.message_name, M.message_mail, M.message_title, M.message_message, DATE_FORMAT(M.message_creation, '%d %M %Y %T') AS DateCrea, S.nom FROM " . _TABLE__MESSAGE . " as M," . _TABLE__STATUTS . " as S WHERE M.message_id = :id AND S.type = 'message' AND S.statut = M.message_status";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->message_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}
	function get_list() {
		$orderby = 'message_id asc';
		$this->query = "SELECT message_id, message_firstname, message_name, message_mail, message_title, message_message, message_creation  FROM " . _TABLE__MESSAGE . " ORDER BY " . $orderby;
		$list = $this->select_no_param();
				
		return $list ;
	}
	
	
	function delete_message() {

			$query = "DELETE FROM " . _TABLE__MESSAGE . " WHERE message_id = :id";
		
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->message_id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true ;
	}
	

	function get_statuts() {
		$query = "SELECT * FROM " . _TABLE__STATUTS . " WHERE type = 'message'";
	
		$list = $this->select_no_param($query);
	
		return $list ;
	}

}
?>