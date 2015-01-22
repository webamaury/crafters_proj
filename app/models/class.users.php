<?php
//parent::__construct()
class classUsers extends CoreModels {

	function login() {

		$accounts = $this->get_array_from_query("SELECT * FROM crafters_user WHERE user_mail = :mail AND user_password = :mdp", 
		$this->mail, $this->password);
						
		// No account found
		if(sizeof($accounts) == 0) {
			return false;
		}
		// More than one account found
		elseif(sizeof($accounts) > 1) {
			return false;
		}
		// One account found - login
		else {
			
			if($accounts[0]->user_status != 0) {
				$session_authed = true;
				
				$_SESSION["CRAFTERS-USER"]["authed"] 		= $session_authed;
				$_SESSION["CRAFTERS-USER"]["verif"] 		= md5($_SERVER['HTTP_USER_AGENT']);
				
				$_SESSION["CRAFTERS-USER"]["id"] 			= $accounts[0]->user_id;
				$_SESSION["CRAFTERS-USER"]["mail"] 		= $accounts[0]->user_mail;
				$_SESSION["CRAFTERS-USER"]["password"] 	= $accounts[0]->user_password;
				$_SESSION["CRAFTERS-USER"]["firstname"] 	= $accounts[0]->user_firstname;
				$_SESSION["CRAFTERS-USER"]["name"] 		= $accounts[0]->user_name;
				$_SESSION["CRAFTERS-USER"]["statut"] 		= $accounts[0]->user_status;
					
				return true;
			}
			else {
				return false;
			}
			
		}
		
	}
	function is_authed() {
		if(isset($_SESSION["CRAFTERS-USER"]["authed"])) {
			return $_SESSION["CRAFTERS-USER"]["authed"];
		}
		else {
			return false;
		}
	}

	function logout() {
	    unset($_SESSION['CRAFTERS-USER']);
		
		//setcookie(COOKIE_NAME . "[admin_login]", '', time() - 3600);
		//setcookie(COOKIE_NAME . "[admin_password]", '', time() - 3600);
	}
	function get_one() {
		$query = "SELECT U.user_id, U.user_firstname, U.user_name, U.user_mail, U.user_birthday, U.user_phone, U.user_creation, S.nom, S.statut FROM " . _TABLE__USERS . " as U," . _TABLE__STATUTS . " as S WHERE U.user_id = :id AND S.type = 'user' AND S.statut = U.user_status";
	
		$champs = ':id';
		$values = $this->user_id; 
	
		$item = $this->select_one_with_one_param($query, $values, $champs);
	
		return $item;
	}
	function get_one_array() {
		$query = "SELECT U.user_id, U.user_firstname, U.user_name, U.user_mail, U.user_birthday, U.user_phone, U.user_creation, S.nom, A.address_numberstreet, A.address_town, A.address_zipcode, A.address_country FROM " . _TABLE__USERS . " as U," . _TABLE__STATUTS . " as S," . _TABLE__ADDRESS . " as A WHERE U.user_id = :id AND S.type = 'user' AND S.statut = U.user_status AND U.user_id = A.user_id_address";
		
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
	
		$cursor->execute();
	
		//$cursor->setFetchMode(PDO::FETCH_ARR);
		$return=$cursor->fetchAll();
		$cursor->closeCursor();
	
		return $return[0] ;	
	}
	function get_list() {
		$orderby = 'user_id asc';
		$this->query = "SELECT user_id, user_firstname, user_name, user_mail FROM " . _TABLE__USERS . " ORDER BY " . $orderby;
			
		$list = $this->select_no_param();
		
		return $list ;
	}

	function delete_user() {
	
			$query = "DELETE FROM " . _TABLE__USERS . " WHERE user_id = :id";
				
			$cursor = $this->connexion->prepare($query);
	
			$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);
			$cursor->execute();
			$cursor->closeCursor();
			return true ;
	}

	function update_user() {
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
		return $return ;
	}

	function get_statuts() {
		$query = "SELECT * FROM " . _TABLE__STATUTS . " WHERE type = 'user'";
	
		$cursor = $this->connexion->prepare($query);
	
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list=$cursor->fetchAll();
		$cursor->closeCursor();

		return $list ;
	}
	function get_crafters_of_month() {
	
		$query = "SELECT user_id, user_username, user_description, user_img_url FROM " . _TABLE__USERS . " WHERE user_month = 1";

		$cursor = $this->connexion->prepare($query);
		
		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$return=$cursor->fetch();
		$cursor->closeCursor();
	
		return $return ;	
	}
	function get_product_of_user() {
		$query = "SELECT product_id, product_name, product_img_url FROM " . _TABLE__PRODUCTS . " WHERE user_id_product = :user_id_product ORDER BY product_id desc LIMIT 0,".$this->limit_month_img;
	
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_id_product', $this->user_id_product, PDO::PARAM_INT);
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list=$cursor->fetchAll();
		$cursor->closeCursor();

		return $list ;
	}
	function get_popular_crafters() {
		$query = "select P.user_id_product, U.user_username, U.user_img_url, count(L.like_id) as nb_like from crafters_like L, crafters_product P, crafters_user U WHERE P.product_id = L.crafters_product_product_id and U.user_id = P.user_id_product and like_date > NOW() - INTERVAL 1 MONTH group by P.user_id_product ORDER BY nb_like desc LIMIT 0,3";
	
		$cursor = $this->connexion->prepare($query);

		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list=$cursor->fetchAll();
		$cursor->closeCursor();

		return $list ;
	}
}
?>