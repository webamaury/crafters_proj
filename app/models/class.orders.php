<?php
//parent::__construct()
/**
 * Class ClassOrders
 */
class ClassOrders extends CoreModels {
		
	/**
	 * Permet à un utilisateur de valider son compte
	 * 
	 */
	public function verif() {
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_status = '1'
		WHERE user_id = :id";
		
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
		
		$return = $cursor->execute();
		return $return;
	}
	
	/**
	 * Permet de voir si le mail existe deja dans la BD
	 * 
	 */
	public function mailUnique() {
		$query = "SELECT count(*) AS nbMail
		FROM  " . _TABLE__USERS . "
		WHERE user_mail = :mail";
		
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		
		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		if ($return->nbMail == 0){
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * Permet de voir si le username existe deja dans la BD
	 * 
	 */
	public function usernameUnique() {
		$query = "SELECT count(*) AS nbUsername
		FROM  " . _TABLE__USERS . "
		WHERE user_username = :username";
		
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':username', $this->username, PDO::PARAM_STR);
		
		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		if ($return->nbUsername == 0){
			return true;
		} else {
			return false;
		}
		
	}

	/**
	 * Permet de vérifier si l'utilisateur est logger
	 * @return bool
     */
	public function isAuthed() {
		if (isset($_SESSION[_SES_NAME]["authed"])) {
			return $_SESSION[_SES_NAME]["authed"];
		} else {
			return false;
		}
	}

	/**
	 * Permet de déconnecter un utilisateur
     */
	public function logout() {
		unset($_SESSION[_SES_NAME]);
		
		//setcookie(COOKIE_NAME . "[admin_login]", '', time() - 3600);
		//setcookie(COOKIE_NAME . "[admin_password]", '', time() - 3600);
	}

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
	 * Permet d'avoir les informations d'un utilisateur en tableau
	 * @return mixed
     */
	public function getOneArray() {
		$query = "SELECT O.order_hash, DATE_FORMAT(O.order_creation, '%d %M %Y %k:%i') AS DateCrea, O.order_status, O.order_delivery, O.order_payment_mode, O.order_price,
			U.user_name, U.user_firstname, S.nom
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
	 * Permet le mail d'un user
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
	 * Permet d'update l'image d'un user
	 * @return array
     */
	function updateImage($image_url, $user) 
	{
		$query = "UPDATE " . _TABLE__USERS . " 
		SET user_img_url = :img_url
		WHERE user_id = :id";
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':img_url', $image_url, PDO::PARAM_STR);
		$cursor->bindValue(':id', $user, PDO::PARAM_INT);
	
		$return = $cursor->execute();
		
		$cursor->closeCursor();

		return $return;
	}
	
	/**
	 * Permet de supprimer l'image d'un produit
	 * @return bool
     */
	function deleteAddressImg() {
		$query = "UPDATE " . _TABLE__USERS . " 
		SET user_img_url = 'NULL'
		WHERE user_id = :id";
		
		$cursor = $this->connexion->prepare($query);
			
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}

	/**
	 * Permet de supprimer un utilisateur
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
	 * Permet de modifier les informations d'un utilisateur
	 * @return bool
     */
	public function updateUser() {
		$query = "UPDATE " . _TABLE__USERS . " 
		SET user_mail = :mail,
		user_firstname = :firstname,
		user_name = :name,
		user_phone = :phone,
		user_birthday = :birthday,
		user_status = :statut 
		WHERE user_id = :id";
		
		$cursor = $this->connexion->prepare($query);
			
		$cursor->bindValue(':mail', $this->user_mail, PDO::PARAM_STR);
		$cursor->bindValue(':firstname', $this->user_firstname, PDO::PARAM_STR);
		$cursor->bindValue(':name', $this->user_name, PDO::PARAM_STR);
		$cursor->bindValue(':phone', $this->user_phone, PDO::PARAM_STR);
		$cursor->bindValue(':birthday', $this->user_birthday, PDO::PARAM_STR);
		$cursor->bindValue(':statut', $this->user_status, PDO::PARAM_INT);
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}

	/**
	 * Permet de récuperer la liste des statuts des utilisateurs
	 * @return array
     */
	public function getStatuts() {
		$query = "SELECT *
			FROM " . _TABLE__STATUTS . "
			WHERE type = 'user'";
	
		$cursor = $this->connexion->prepare($query);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}

	/**
	 * Permet d'obtenir le crafters du mois
	 * @return mixed
     */
	public function getCraftersOfMonth() {
		$query = "SELECT user_id,
			user_username,
			user_description,
			user_img_url
			FROM " . _TABLE__USERS . "
			WHERE user_month = 1";

		$cursor = $this->connexion->prepare($query);
		
		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return = $cursor->fetch();
		$cursor->closeCursor();
	
		return $return;
	}

	/**
	 * Permet d'avoir les produits d'un utilisateur
	 * @param $limit
	 * @param $user_id
	 * @return array
     */
	public function getProductOfUser($limit, $user_id) {
		$query = "SELECT product_id,
			product_name,
			product_img_url
			FROM " . _TABLE__PRODUCTS . "
			WHERE user_id_product = :user_id_product
			ORDER BY product_id DESC
			LIMIT 0," . $limit;
	
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_id_product', $user_id, PDO::PARAM_INT);
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}

	/**
	 * Permet d'avoir les 3 utilisateurs cumulant le plus likes
	 * @return array
     */
	public function getPopularCrafters() {
		$query = "SELECT P.user_id_product,
			U.user_username,
			U.user_img_url,
			count(L.like_id) as nb_like
			FROM crafters_like L, crafters_product P, crafters_user U
			WHERE P.product_id = L.crafters_product_product_id
			and U.user_id = P.user_id_product
			and like_date > NOW() - INTERVAL 1 MONTH
			GROUP BY P.user_id_product
			ORDER BY nb_like DESC
			LIMIT 0,3";
	
		$cursor = $this->connexion->prepare($query);

		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}
}
?>