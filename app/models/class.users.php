<?php
//parent::__construct()
/**
 * Class ClassUsers
 */
class ClassUsers extends CoreModel {
	/**
	 * Permet de logger un utilisateur
	 * @return bool
	 */
	public function login() {
		$accounts = $this->get_array_from_query("SELECT * FROM crafters_user WHERE user_mail = :mail AND user_password = :mdp",
		$this->mail, $this->password);
						
		// No account found
		if (count($accounts) === 0) {
			return 'error0';
		} elseif (count($accounts) > 1) { // More than one account found
			return 'error1';
		} else { // One account found - login
			if ($accounts[0]->user_status != 0) {
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
				return 'error2';
			}
		}
	}
	
	/**
	 * Permet à un utilisateur de s'incscrire
	 * 
	 */
	public function signup() {
		$query = "INSERT INTO " . _TABLE__USERS . " 
		(user_firstname, user_name, user_mail, user_password, user_username) 
		VALUES 
		(:user_firstname, :user_name, :user_mail, :user_password, :user_username)";
		$cursor = $this->connexion->prepare($query);
	
		$cursor->bindValue(':user_firstname', $this->user_firstname, PDO::PARAM_STR);
		$cursor->bindValue(':user_name', $this->user_name, PDO::PARAM_STR);
		$cursor->bindValue(':user_mail', $this->user_mail, PDO::PARAM_STR);
		$cursor->bindValue(':user_password', $this->user_password, PDO::PARAM_STR);
		$cursor->bindValue(':user_username', $this->user_username, PDO::PARAM_STR);
	
		$cursor->execute();
		
		$return = $this->connexion->lastInsertId();
		
		$cursor->closeCursor();

		return $return;
	}
	
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

	function getNewMail()
	{
		$query = "SELECT
			user_newmail
			FROM " . _TABLE__USERS . "
			WHERE user_newmail_hash = :user_newmail_hash";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_newmail_hash', $this->user_newmail_hash, PDO::PARAM_STR);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;
	}

	function confirmNewMail()
	{
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_mail = user_newmail,
		user_newmail = '',
		user_newmail_hash = ''
		WHERE user_newmail_hash = :user_newmail_hash";

		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_newmail_hash', $this->user_newmail_hash, PDO::PARAM_STR);

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
		WHERE user_mail = :user_mail";

		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_mail', $this->user_mail, PDO::PARAM_STR);
		
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
		WHERE user_username = :user_username";
		
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_username', $this->user_username, PDO::PARAM_STR);
		
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
	 * Permet d'avoir les informations d'un utilisateur
	 * @return mixed
     */
	public function getOne() {
		$query = "SELECT
			U.user_id,
			U.user_firstname,
			U.user_name,
			U.user_mail,
			U.user_description,
			U.user_username,
			DATE_FORMAT(U.user_birthday, '%d %M %Y') AS DateBirth,
			U.user_birthday,
			U.user_phone,
			DATE_FORMAT(U.user_creation, '%d %M %Y %T') AS DateCrea,
			U.user_description,
			U.user_month,
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
			DATE_FORMAT(U.user_creation, '%d %M %Y') AS DateCrea,
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
		$this->query = "SELECT U.user_id, U.user_firstname, U.user_name, U.user_mail, DATE_FORMAT(U.user_creation, '%d %M %Y') AS user_creation, S.nom
				FROM " . _TABLE__USERS . " as U, " . _TABLE__STATUTS . " as S
				WHERE S.type = 'user'
				AND S.statut = U.user_status
				ORDER BY " . $orderby;
			
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
		user_username = :username,
		user_phone = :phone,
		user_birthday = :birthday,
		user_status = :statut,
		user_month = :checkbox_month,
		user_description = :descr_month
		WHERE user_id = :id";
		
		$cursor = $this->connexion->prepare($query);
			
		$cursor->bindValue(':mail', $this->user_mail, PDO::PARAM_STR);
		$cursor->bindValue(':firstname', $this->user_firstname, PDO::PARAM_STR);
		$cursor->bindValue(':name', $this->user_name, PDO::PARAM_STR);
		$cursor->bindValue(':username', $this->user_username, PDO::PARAM_STR);
		$cursor->bindValue(':phone', $this->user_phone, PDO::PARAM_STR);
		$cursor->bindValue(':birthday', $this->user_birthday, PDO::PARAM_STR);
		$cursor->bindValue(':statut', $this->user_status, PDO::PARAM_INT);
		$cursor->bindValue(':checkbox_month', $this->user_month, PDO::PARAM_INT);
		$cursor->bindValue(':descr_month', $this->user_description, PDO::PARAM_STR);
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}

	/**
	 * Permet de passer tout les user_month à 0
	 * @return bool
	 */
	public function clearUserMonth() {
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_month = 0";

		$cursor = $this->connexion->prepare($query);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}

	/**
	 * Permet de modifier les informations d'un utilisateur dans le front
	 * @return bool
	 */
	public function updateUserFront() {
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_newmail = :mail,
		user_newmail_hash = :user_newmail_hash,
		user_firstname = :firstname,
		user_name = :name,
		user_username = :username,
		user_phone = :phone,
		user_birthday = :birthday,
		user_status = :statut
		WHERE user_id = :id";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':mail', $this->user_mail, PDO::PARAM_STR);
		$cursor->bindValue(':user_newmail_hash', $this->user_newmail_hash, PDO::PARAM_STR);
		$cursor->bindValue(':firstname', $this->user_firstname, PDO::PARAM_STR);
		$cursor->bindValue(':name', $this->user_name, PDO::PARAM_STR);
		$cursor->bindValue(':username', $this->user_username, PDO::PARAM_STR);
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
			AND product_status = 2
			ORDER BY product_id DESC
			LIMIT " . $limit;
	
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_id_product', $user_id, PDO::PARAM_INT);
		$cursor->execute();
	
		$cursor->setFetchMode(PDO::FETCH_OBJ);		
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}
	/**
	 * Permet d'avoir les produits d'un utilisateur
	 * @param $limit
	 * @param $user_id
	 * @return array
     */
	public function getMyProducts($limit, $user_id) {
		$query = "SELECT product_id,
			product_name,
			product_img_url
			FROM " . _TABLE__PRODUCTS . "
			WHERE user_id_product = :user_id_product
			ORDER BY product_id DESC
			LIMIT " . $limit;

		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_id_product', $user_id, PDO::PARAM_INT);
		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$list = $cursor->fetchAll();
		$cursor->closeCursor();

		return $list;
	}
	/**
	 * Permet d'avoir les commandes d'un utilisateur
	 * @param $limit
	 * @param $user_id
	 * @return array
	 */
	public function getOrdersOfUser($limit, $user_id) {
		$query = "SELECT order_id,
			order_price,
			order_hash,
			order_delivery,
			order_payment_mode,
			order_status,
			DATE_FORMAT(order_creation, '%d %M %Y %H:%i') as order_creation
			FROM " . _TABLE__COMMANDES . "
			WHERE user_id_order = :user_id_order
			ORDER BY order_id DESC
			LIMIT 0," . $limit;

		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':user_id_order', $user_id, PDO::PARAM_INT);
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
		//var_dump($list);
		return $list;
	}

	function updateImgUrl()
	{
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_img_url = :img_url
		WHERE user_id = :id";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':img_url', $this->img_url, PDO::PARAM_STR);
		$cursor->bindValue(':id', $this->user_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}
	function updatePassword()
	{
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_password = :user_password
		WHERE user_id = :user_id";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_password', $this->user_password, PDO::PARAM_STR);
		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}
	function updatePasswordWithHash()
	{
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_password = :user_password
		WHERE user_forgot_hash = :user_forgot_hash";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_password', $this->user_password, PDO::PARAM_STR);
		$cursor->bindValue(':user_forgot_hash', $this->user_forgot_hash, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}
	function forgotInputHash()
	{
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_forgot_hash = :user_forgot_hash
		WHERE user_mail = :user_mail";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_forgot_hash', $this->user_forgot_hash, PDO::PARAM_STR);
		$cursor->bindValue(':user_mail', $this->user_mail, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}
	function hashExist()
	{
		$query = "SELECT user_id, user_mail
			FROM " . _TABLE__USERS . "
			WHERE user_forgot_hash = :user_forgot_hash";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_forgot_hash', $this->user_forgot_hash, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		if (count($return) == 1) {
			return $return;
		} else {
			return false;
		}
	}
	function cleanHash()
	{
		$query = "UPDATE " . _TABLE__USERS . "
		SET user_forgot_hash = ''
		WHERE user_forgot_hash = :user_forgot_hash";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_forgot_hash', $this->user_forgot_hash, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();
		return $return;
	}

	/**
	 * Calcule le nombre de user ajouté il y a 1 mois
	 */
	public function getNewUser() {
		$query = "SELECT count(user_id) as nbUser
			FROM " . _TABLE__USERS . "
			WHERE user_creation > DATE_ADD(NOW(),INTERVAL -30 DAY)";

		$cursor = $this->connexion->prepare($query);

		$cursor->execute();

		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;
	}

	function insertMailNotif()
	{
		$query = "INSERT INTO crafters_BDDmail
		(mail)
		VALUES
		(:mail)";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':mail', $this->mail, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}
	/**
	 * Permet de voir si le mail existe deja dans la BD
	 *
	 */
	public function BDDmailUnique() {
		$query = "SELECT count(*) AS nbMail
		FROM  crafters_BDDmail
		WHERE mail = :mail";

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

}
?>