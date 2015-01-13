<?php

class classProduct extends CoreModels {

	function insert_new() {
		$query = "INSERT INTO crafters_product 
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

}

?>