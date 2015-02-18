<?php

/**
 * Class ClassProducts
 */
class ClassProducts extends CoreModels 
{

	/**
	 * Permet dinsérer un nouveau produit
	 * @return bool
     */
	function insertNew() 
	{
		$query = "INSERT INTO " . _TABLE__PRODUCTS . " 
		(product_name, product_description, product_status, product_img_url, user_id_product)
		VALUES 
		(:name, :descr, :status, :img_url, :user_id)";
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':name', $this->name, PDO::PARAM_STR);
		$cursor->bindValue(':descr', $this->descr, PDO::PARAM_STR);
		$cursor->bindValue(':status', $this->status, PDO::PARAM_STR);
		$cursor->bindValue(':img_url', $this->img_url, PDO::PARAM_STR);
		$cursor->bindValue(':user_id', $_SESSION[_SES_NAME]["id"], PDO::PARAM_STR);
	
		$cursor->execute();

		$return = $this->connexion->lastInsertId();

		$cursor->closeCursor();

		return $return;
	}

	/**
	 * @param $image_url
	 * @param $product
	 * @return bool
	 */
	function updateImage($image_url, $product)
	{
		$query = "UPDATE " . _TABLE__PRODUCTS . "
		SET product_img_url = :img_url
		WHERE product_id = :id";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':img_url', $image_url, PDO::PARAM_STR);
		$cursor->bindValue(':id', $product, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}

	/**
	 * Permet d'obtenir la liste de touts les produits classé par statut pour avoir les produits non-validé en haut dans le BO
	 * @return array
     */
	function getList() {
		$orderby = 'S.statut asc';
		$this->query = "SELECT P.product_img_url,
			P.product_id,
			P.product_name,
			DATE_FORMAT(P.product_creation, '%d %M %Y %k:%i') AS product_creation,
			S.nom as
			status_name
			FROM " . _TABLE__PRODUCTS . " P, " . _TABLE__STATUTS . " S
			WHERE S.statut = P.product_status and S.type = 'product'
			ORDER BY " . $orderby;
		$list = $this->select_no_param();

		return $list;
	}

	/**
	 * Permet d'avoir un produit (object)
	 * @return mixed
     */
	function get0ne() {
		$query = "SELECT P.product_id,
			P.product_name,
			P.product_description,
			DATE_FORMAT(P.product_creation, '%d %M %Y %T') AS DateCrea,
			P.user_id_product,
			P.product_status,
			P.product_img_url,
			S.nom,
			S.statut
			FROM " . _TABLE__PRODUCTS . " as P," . _TABLE__STATUTS . " as S
			WHERE P.product_id = :id AND S.type = 'product' AND S.statut = P.product_status";
		
	
		$champs = ':id';
		$values = $this->product_id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}

	/**
	 * Permet d'avoir un produit dans un tableau
	 * @return mixed
     */
	function getOneArray() {
		$query = "SELECT P.product_id,

			P.product_name, P.product_description,
			DATE_FORMAT(P.product_creation, '%d %M %Y %T') AS DateCrea,
			P.product_status,
			P.product_img_url,
			S.nom
			FROM " . _TABLE__PRODUCTS . " as P," . _TABLE__STATUTS . " as S
			WHERE P.product_id = :id AND S.type = 'product' AND S.statut = P.product_status";

		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		$return = $cursor->fetch();
		$cursor->closeCursor();
	
		return $return;
	}

	/**
	 * Permet de supprimer un produit
	 * @return bool
     */
	function deleteProduct() {

			$query = "DELETE FROM " . _TABLE__PRODUCTS . " WHERE product_id = :id";
		
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);
			$return = $cursor->execute();
			$cursor->closeCursor();
			return $return;
	}

	/**
	 * Permet d'afficher les produits dans le front
	 * @return array
     */
	function getListFront($orderby = 'product_id DESC', $search = null) {
		$query = "SELECT P.product_id,
			P.product_name,
			P.product_img_url,
			P.product_nblike,
			U.user_username
			FROM " . _TABLE__PRODUCTS . " P, " . _TABLE__USERS . " U
			WHERE P.user_id_product = U.user_id and P.product_status = 2" . $search . "
			ORDER BY " . $orderby . "
			LIMIT " . $this->limit;
		$cursor = $this->connexion->prepare($query);
		
		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return = $cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return;
	}

	/**
	 * Permet d'obtenir le nombre de like d'un produit
	 * @return mixed
     */
	function numberOfLike() {
		$query = "SELECT count(like_id) as nb_like
			FROM " . _TABLE__LIKE . "
			WHERE crafters_product_product_id = :id";

		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return = $cursor->fetch();
		$cursor->closeCursor();
	
		return $return;
	
	}

	/**
	 * Permet de modifier un produit
	 * @return bool
     */
	function updateProduct() {
		$query = "UPDATE " . _TABLE__PRODUCTS . " 
		SET product_name = :name,
		product_description = :description,
		product_status = :statut
		WHERE product_id = :id";
		
		$cursor = $this->connexion->prepare($query);
			
		$cursor->bindValue(':name', $this->product_name, PDO::PARAM_STR);
		$cursor->bindValue(':description', $this->product_description, PDO::PARAM_STR);
		$cursor->bindValue(':statut', $this->product_status, PDO::PARAM_INT);
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}

	/**
	 * Permet d'obtenir la liste des statuts de type produit
	 * @return array
     */
	function getStatuts() {
		$query = "SELECT *
			FROM " . _TABLE__STATUTS . "
			WHERE type = 'product'";
	
		$cursor = $this->connexion->prepare($query);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}

	/**
	 * Permet de supprimer l'image d'un produit
	 * @return bool
     */
	function deleteAddressImg() {
		$query = "UPDATE " . _TABLE__PRODUCTS . " 
		SET product_img_url = 'NULL'
		WHERE product_id = :id";
		
		$cursor = $this->connexion->prepare($query);
			
		$cursor->bindValue(':id', $this->product_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}

	/**
	 * permet de liker un produit
	 * @return bool
     */
	function likeProduct() {
		$query = "INSERT INTO " . _TABLE__LIKE . " 
		(crafters_product_product_id, crafters_user_user_id) 
		VALUES 
		(:product_id, :user_id)";
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);
		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
	
		$return = $cursor->execute();
		
		$cursor->closeCursor();

		return $return;
	}

	/**
	 * permet de supprimer un like
	 * @return bool
     */
	function unlikeProduct() {
		$query = "DELETE FROM " . _TABLE__LIKE . " WHERE crafters_product_product_id = :product_id and crafters_user_user_id = :user_id";
	
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);
		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);

		$return = $cursor->execute();
		$cursor->closeCursor();
		return $return;
	}

	/**
	 * Permet de savoir si l'utilisateur connecté à liké un produit
	 * @return bool
     */
	function didILike() {
		$query = "SELECT count(like_id) as nb_like
			FROM " . _TABLE__LIKE . "
			WHERE crafters_product_product_id = :product_id and crafters_user_user_id = :user_id";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);
		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);

		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return = $cursor->fetch();
		$cursor->closeCursor();
		if ((int)$return->nb_like === 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Permet d'avoir les noms des utilisateurs qui ont liké
	 * @return array
     */
	function getUsersWhoLiked() {
		$query = "SELECT U.user_username
			FROM " . _TABLE__LIKE . " L, " . _TABLE__USERS . " U
			WHERE L.crafters_user_user_id = U.user_id and L.crafters_product_product_id = :product_id
			ORDER BY L.like_id DESC
			LIMIT 0,5";
	
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);

		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}

	/**
	 * @return array
	 */
	public function get_search_tag() {
		$query = "SELECT P.product_name
			FROM " . _TABLE__PRODUCTS . " P
			WHERE P.product_name LIKE :product_name
			ORDER BY P.product_name ASC
			LIMIT 0,15";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':product_name', $this->product_name, PDO::PARAM_STR);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}
}

?>