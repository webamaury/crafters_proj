<?php

class classProducts extends CoreModels {

	function insert_new() {
		$query = "INSERT INTO " . _TABLE__PRODUCTS . " 
		(product_name, product_description, product_status, product_type, product_img_url, user_id_product) 
		VALUES 
		(:name, :descr, :status, :type, :img_url, :user_id)";
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':name', $this->name, PDO::PARAM_STR);
		$cursor->bindValue(':descr', $this->descr, PDO::PARAM_STR);
		$cursor->bindValue(':status', $this->status, PDO::PARAM_STR);
		$cursor->bindValue(':type', $this->type, PDO::PARAM_STR);
		$cursor->bindValue(':img_url', $this->img_url, PDO::PARAM_STR);
		$cursor->bindValue(':user_id', $_SESSION["CRAFTERS-USER"]["id"], PDO::PARAM_STR);
	
		$return = $cursor->execute();
		
		$cursor->closeCursor();

		return $return ;
	}
	
	function get_list() {
		$orderby = 'S.statut asc';
		$this->query = "SELECT P.product_img_url, P.product_id, P.product_name, P.product_type, S.nom as status_name  FROM " . _TABLE__PRODUCTS . " P, " . _TABLE__STATUTS . " S WHERE S.statut = P.product_status and S.type = 'product' ORDER BY " . $orderby;
		$list = $this->select_no_param();
				
		return $list ;
	}
	
	function get_one() {
		$query = "SELECT P.product_id, P.product_name, P.product_description, P.product_creation, P.product_status, P.product_type, P.product_img_url, S.nom, S.statut FROM " . _TABLE__PRODUCTS . " as P," . _TABLE__STATUTS . " as S WHERE P.product_id = :id AND S.type = 'product' AND S.statut = P.product_status";
		
	
		$champs = ':id';
		$values = $this->product_id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}
	function get_one_array() {
		$query = "SELECT P.product_id, P.product_name, P.product_description, P.product_creation, P.product_status, P.product_type, P.product_img_url, S.nom FROM " . _TABLE__PRODUCTS . " as P," . _TABLE__STATUTS . " as S WHERE P.product_id = :id AND S.type = 'product' AND S.statut = P.product_status";

		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}
	
	function delete_product() {

			$query = "DELETE FROM " . _TABLE__PRODUCTS . " WHERE product_id = :id";
		
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true ;
	}
	
	function get_list_front() {
		$query = "SELECT P.product_id, P.product_name, P.product_img_url, U.user_username FROM " . _TABLE__PRODUCTS . " as P, " . _TABLE__USERS . " as U WHERE P.user_id_product = U.user_id and P.product_status = 1 ORDER BY product_id desc LIMIT ".$this->limit;
		$cursor = $this->connexion->prepare($query);
		
		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return ;	
	
	}
	function number_of_like() {
		$query = "SELECT count(like_id) as nb_like from " . _TABLE__LIKE . " WHERE crafters_product_product_id = :id";
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	
	}
	
	function update_product() {
		$query = "UPDATE " . _TABLE__PRODUCTS . " 
		SET product_name = :name,
		product_description = :description,
		product_status = :statut,
		product_type = :type
		WHERE product_id = :id";
		
		$cursor = $this->connexion->prepare($query);
			
		$cursor->bindValue(':name', $this->product_name, PDO::PARAM_STR);
		$cursor->bindValue(':description', $this->product_description, PDO::PARAM_STR);
		$cursor->bindValue(':statut', $this->product_status, PDO::PARAM_INT);
		$cursor->bindValue(':type', $this->product_type, PDO::PARAM_STR);
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return ;
	}
	
	function get_statuts() {
		$query = "SELECT * FROM " . _TABLE__STATUTS . " WHERE type = 'product'";
	
		$cursor = $this->connexion->prepare($query);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list=$cursor->fetchAll();
		$cursor->closeCursor();

		return $list ;
	}
	
	function delete_address_img() {
		$query = "UPDATE " . _TABLE__PRODUCTS . " 
		SET product_img_url = 'NULL'
		WHERE product_id = :id";
		
		$cursor = $this->connexion->prepare($query);
			
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return ;
	}
	function like_product() {
		$query = "INSERT INTO " . _TABLE__LIKE . " 
		(crafters_product_product_id, crafters_user_user_id) 
		VALUES 
		(:product_id, :user_id)";
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);
		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
	
		$return = $cursor->execute();
		
		$cursor->closeCursor();

		return $return ;
	}
	function did_i_like() {
		
	}

}

?>