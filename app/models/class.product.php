<?php

class classProducts extends CoreModels {

	function insert_new() {
		$query = "INSERT INTO " . _TABLE__PRODUCTS . " 
		(product_name, product_description, product_status, product_type, product_img_url) 
		VALUES 
		(:name, :descr, :status, :type, :img_url)";
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':name', $this->name, PDO::PARAM_STR);
		$cursor->bindValue(':descr', $this->descr, PDO::PARAM_STR);
		$cursor->bindValue(':status', $this->status, PDO::PARAM_STR);
		$cursor->bindValue(':type', $this->type, PDO::PARAM_STR);
		$cursor->bindValue(':img_url', $this->img_url, PDO::PARAM_STR);
	
		$return = $cursor->execute();
		
		$cursor->closeCursor();
		
		return $return ;
	}
	
	function get_list() {
		$orderby = 'product_id asc';
		$this->query = "SELECT product_img_url, product_id, product_name, product_description, product_type  FROM " . _TABLE__PRODUCTS . " ORDER BY " . $orderby;
		$list = $this->select_no_param();
				
		return $list ;
	}
	
	function get_one() {
		$query = "SELECT P.product_id, P.product_name, P.product_description, P.product_creation, P.product_status, P.product_type, S.nom, S.statut FROM " . _TABLE__PRODUCTS . " as P," . _TABLE__STATUTS . " as S WHERE P.product_id = :id AND S.type = 'product' AND S.statut = P.product_status";
		
	
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
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}

}

?>