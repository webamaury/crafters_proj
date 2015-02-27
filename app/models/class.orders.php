<?php
//parent::__construct()
/**
 * Class ClassOrders
 */
class ClassOrders extends CoreModel {

	/**
	 * Permet à un admin de changer le statut d'une commande à 2
	 *
	 */
	public function statutSend() {
		$query = "UPDATE " . _TABLE__COMMANDES . "
		SET order_status = 2
		WHERE order_hash = :order_hash";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}

	/**
	 * Permet à un admin de changer le statut d'une commande à 1
	 *
	 */
	public function statutPaid() {
		$query = "UPDATE " . _TABLE__COMMANDES . "
		SET order_status = 1
		WHERE order_hash = :order_hash";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}

	/**
	 * Permet d'avoir l'id d'une commande à partir de son hash
	 *
	 */
	public function getOrderWithHash() {
		$query = "SELECT * FROM " . _TABLE__COMMANDES . "
		WHERE order_hash = :order_hash";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);

		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;
	}

	/**
	 * Permet d'avoir une liste avec toutes les commandes
	 * @return array
     */
	public function getList() {
		$this->query = "SELECT 
		O.order_id, O.order_delivery, O.order_payment_mode, O.order_price,
		DATE_FORMAT(O.order_creation, '%d %M %Y %k:%i') AS DateCrea,
		SUM(P.product_order_quantity) as nbProduit,  
		U.user_username, S.nom
		FROM " . _TABLE__ORDER . " as O,  " . _TABLE__PRODUCT_ORDER . " as P, " . _TABLE__USERS . " as U, " . _TABLE__STATUTS . " as S
		WHERE O.order_id = P.order_id
		AND O.user_id_order = U.user_id
		AND O.order_status = S.statut
		AND S.type = 'order'
		GROUP BY O.order_id";
			
		$list = $this->select_no_param();
		
		return $list;
	}

	/**
	 * Permet d'avoir les informations d'une commande en tableau
	 * @return mixed
     */
	public function getOneArray() {
		$query = "SELECT O.order_hash, DATE_FORMAT(O.order_creation, '%d %M %Y %k:%i') AS DateCrea, O.order_status, O.order_delivery, O.order_payment_mode, O.order_price,
			U.user_name, U.user_firstname, U.user_mail, S.nom
			FROM " . _TABLE__ORDER . " as O, " . _TABLE__USERS . " as U, " . _TABLE__STATUTS . " as S
			WHERE O.user_id_order = U.user_id
			AND O.order_status = S.statut
			AND S.type = 'order'
			AND O.order_id = :id";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->order_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return = $cursor->fetch();
		$cursor->closeCursor();
	
		return $return;
	}

	/**
	 * Permet d'avoir les adresses d'un utilisateur de la commande en tableau
	 * @return mixed
	 */
	public function getOneArrayAddress() {
		$query = "SELECT A.address_numberstreet, A.address_town, A.address_zipcode, A.address_country, A.address_firstname, A.address_name,
			S.nom, O.order_id
			FROM " . _TABLE__ADDRESS . " as A, " . _TABLE__ORDER . " as O, " . _TABLE__STATUTS . " as S
			WHERE O.order_id = A.crafters_order_order_id
			AND A.address_status = S.statut
			AND S.type = 'address'
			AND O.order_id = :id";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':id', $this->order_id, PDO::PARAM_INT);

		$cursor->execute();

		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return = $cursor->fetchAll();
		$cursor->closeCursor();

		return $return;
	}
	
	/**
	 * Permet d'avoir les produits d'une commande en tableau
	 * @return mixed
     */
	public function getOneArrayProduct() {
		$query = "SELECT P.product_id, P.product_name,
			O.product_order_type, O.product_id, O.order_id, O.product_order_quantity, O.product_order_size
			FROM " . _TABLE__PRODUCT_ORDER . " as O, " . _TABLE__PRODUCTS . " as P
			WHERE P.product_id = O.product_id
			AND O.order_id = :id";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->order_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return = $cursor->fetchAll();
		$cursor->closeCursor();

		return $return;
	}

	/**
	 * Permet d'avoir le user d'une commande
	 * @return array
	 */
	function getUserOfOrder()
	{
		$query = "SELECT U.user_firstname, U.user_name, U.user_mail
			FROM " . _TABLE__ORDER . " as O, " . _TABLE__USERS . " as U
			WHERE U.user_id = O.user_id_order
			AND O.order_hash = :order_hash";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;

	}

	/**
	 * Permet de supprimer une commande
	 * @return bool
     */
	public function deleteOrder() {
			$query = "DELETE FROM " . _TABLE__ORDER . " WHERE order_id = :id";
				
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->order_id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true;
	}

	/**
	 * Calcule et affiche le nombre de commande ajouté il y a 1 mois
	 */
	public function getNewOrder() {
		$query = "SELECT count(order_id) as nbOrder
			FROM " . _TABLE__ORDER . "
			WHERE order_creation > DATE_ADD(NOW(),INTERVAL -30 DAY)";

		$cursor = $this->connexion->prepare($query);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;
	}
}
?>