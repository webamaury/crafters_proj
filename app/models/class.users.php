<?php
//parent::__construct()
/**
 * Class ClassUsers
 */
class ClassUsers extends CoreModels {
	/**
	 * Permet de logger un utilisateur
	 * @return bool
	 */
	public function login() {
		$accounts = $this->get_array_from_query("SELECT * FROM crafters_user WHERE user_mail = :mail AND user_password = :mdp",
		$this->mail, $this->password);
						
		// No account found
		if (count($accounts) === 0) {
			return false;
		} elseif (count($accounts) > 1) { // More than one account found
			return false;
		} else { // One account found - login
			if ($accounts[0]->user_status !== 0) {
				$session_authed = true;
				
				$_SESSION[_SES_NAME]["authed"] 		    = $session_authed;
				$_SESSION[_SES_NAME]["verif"] 		    = md5($_SERVER['HTTP_USER_AGENT']);
				
				$_SESSION[_SES_NAME]["id"] 			    = $accounts[0]->user_id;
				$_SESSION[_SES_NAME]["mail"] 			= $accounts[0]->user_mail;
				$_SESSION[_SES_NAME]["password"] 		= $accounts[0]->user_password;
				$_SESSION[_SES_NAME]["firstname"] 	    = $accounts[0]->user_firstname;
				$_SESSION[_SES_NAME]["name"] 			= $accounts[0]->user_name;
				$_SESSION[_SES_NAME]["username"] 	    = $accounts[0]->user_username;
				$_SESSION[_SES_NAME]["statut"] 		    = $accounts[0]->user_status;
					
				return true;
			} else {
				return false;
			}
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
	 * Permet d'avoir les informations d'un utilisateur
	 * @return mixed
     */
	public function getOne() {
		$query = "SELECT
			U.user_id,
			U.user_firstname,
			U.user_name,
			U.user_mail,
			DATE_FORMAT(U.user_birthday, '%d %M %Y') AS DateBirth,
			U.user_phone,
			DATE_FORMAT(U.user_creation, '%d %M %Y %T') AS DateCrea,
			U.user_img_url,
			S.nom,
			S.statut
			FROM " . _TABLE__USERS . " as U," . _TABLE__STATUTS . " as S
			WHERE U.user_id = :id AND S.type = 'user' AND S.statut = U.user_status";
	
		$champs = ':id';
		$values = $this->user_id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}

	/**
	 * Permet d'avoir les informations d'un utilisateur en tableau
	 * @return mixed
     */
	public function getOneArray() {
		$query = "SELECT
			U.user_id,
			U.user_firstname,
			U.user_name,
			U.user_mail,
			DATE_FORMAT(U.user_birthday, '%d %M %Y') AS DateBirth,
			U.user_phone,
			DATE_FORMAT(U.user_creation, '%d %M %Y %T') AS DateCrea,
			U.user_img_url,
			S.nom
			FROM " . _TABLE__USERS . " as U," . _TABLE__STATUTS . " as S
			WHERE U.user_id = :id AND S.type = 'user' AND S.statut = U.user_status";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return = $cursor->fetch();
		$cursor->closeCursor();
	
		return $return;
	}
	
	/**
	 * Permet d'avoir l'adresse de facturation d'un utilisateur en tableau
	 * @return mixed
     */
	public function getOneArrayAddress() {
		$query = "SELECT
			U.user_id,
			S.nom,
			A.address_numberstreet,
			A.address_town,
			A.address_zipcode,
			A.address_country
			FROM " . _TABLE__USERS . " as U," . _TABLE__STATUTS . " as S," . _TABLE__ADDRESS . " as A
			WHERE U.user_id = :id
			AND U.user_id = A.user_id_address
			AND S.statut = A.address_status
			AND S.type = 'address'
			AND A.address_status = 0";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
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
	 * Permet d'avoir une liste avec tous les users
	 * @return array
     */
	public function getList() {
		$orderby = 'user_id asc';
		$this->query = "SELECT user_id, user_firstname, user_name, user_mail FROM " . _TABLE__USERS . " ORDER BY " . $orderby;
			
		$list = $this->select_no_param();
		
		return $list;
	}

	/**
	 * Permet de supprimer un utilisateur
	 * @return bool
     */
	public function deleteUser() {
			$query = "DELETE FROM " . _TABLE__USERS . " WHERE user_id = :id";
				
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
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