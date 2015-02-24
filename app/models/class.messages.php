<?php
/**
 * Class classMessages
 */
class ClassMessages extends CoreModels {

	/**
	 * @return mixed
     */
	function getOne() {
		$query = "SELECT M.message_id, M.message_firstname, M.message_name, M.message_mail, M.message_message, M.message_creation, S.nom, S.statut FROM " . _TABLE__MESSAGE . " as M," . _TABLE__STATUTS . " as S WHERE M.message_id = :id AND S.type = 'message' AND S.statut = M.message_status";
		
	
		$champs = ':id';
		$values = $this->message_id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}

	/**
	 * @return mixed
     */
	function get_one_array() {
		$query = "SELECT M.message_id, M.message_firstname, M.message_name, M.message_mail, M.message_message, DATE_FORMAT(M.message_creation, '%d %M %Y %T') AS DateCrea, S.nom FROM " . _TABLE__MESSAGE . " as M," . _TABLE__STATUTS . " as S WHERE M.message_id = :id AND S.type = 'message' AND S.statut = M.message_status";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->message_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}

	/**
	 * @return array
     */
	function get_list() {
		$orderby = 'message_id DESC';
		$this->query = "SELECT
					M.message_id,
					M.message_mail,
					S.nom as status_name,
					DATE_FORMAT(M.message_creation, '%d %M %Y %T') as message_creation
					FROM " . _TABLE__MESSAGE . " M, " . _TABLE__STATUTS . " S
					WHERE S.type = 'message'
					AND S.statut = M.message_status
					ORDER BY " . $orderby;
		$list = $this->select_no_param();
				
		return $list ;
	}


	/**
	 * @return bool
     */
	function delete_message() {

			$query = "DELETE FROM " . _TABLE__MESSAGE . " WHERE message_id = :id";
		
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->message_id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true ;
	}


	/**
	 * @return array
     */
	function get_statuts() {
		$query = "SELECT * FROM " . _TABLE__STATUTS . " WHERE type = 'message'";
	
		$list = $this->select_no_param($query);
	
		return $list ;
	}

	function newMessage() {

		$query = "INSERT INTO " . _TABLE__MESSAGE . "
		(message_firstname, message_name, message_mail, message_message)
		VALUES (:message_firstname, :message_name, :message_mail, :message_message)";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':message_firstname', $this->message_firstname, PDO::PARAM_STR);
		$cursor->bindValue(':message_name', $this->message_name, PDO::PARAM_STR);
		$cursor->bindValue(':message_mail', $this->message_mail, PDO::PARAM_STR);
		$cursor->bindValue(':message_message', $this->message_message, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return ;

	}

	function readMessage()
	{
		$query = "UPDATE " . _TABLE__MESSAGE . "
		SET message_status = 1
		WHERE message_id = :message_id";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':message_id', $this->message_id, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}

	/**
	 * Calcule le nombre de message ajouté il y a 1 mois
	 */
	public function getNewMessage() {
		$query = "SELECT count(message_id) as nbMessage
			FROM " . _TABLE__MESSAGE . "
			WHERE message_creation > DATE_ADD(NOW(),INTERVAL -32 DAY)";

		$cursor = $this->connexion->prepare($query);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;
	}

}
?>