<?php
function get_list($orderby = 'id asc') {
	$query = "SELECT * FROM " . _TABLE__ADMIN_USERS . " ORDER BY " . $orderby;

	$list = select_no_param($query);

	return $list ;
}

function get_one($id) {
	$query = "SELECT * FROM " . _TABLE__ADMIN_USERS . " WHERE id = :id";

	$champs = ':id';
	$values = $id; 

	$item = select_param($query, $champs, $values);

	return $item;
}

function create_admin($mail, $firstname, $name, $phone, $statut) {
	$query = "INSERT INTO nomduprojet_admin_users 
	(mail, firstname, name, phone, statut) 
	VALUES 
	(:mail, :firstname, :name, :phone, :statut)";

	global $connexion;

	$cursor = $connexion->prepare($query);

	$cursor->bindValue(':mail', $mail, PDO::PARAM_STR);
	$cursor->bindValue(':firstname', $firstname, PDO::PARAM_STR);
	$cursor->bindValue(':name', $name, PDO::PARAM_STR);
	$cursor->bindValue(':phone', $phone, PDO::PARAM_STR);
	$cursor->bindValue(':statut', $statut, PDO::PARAM_INT);

	$cursor->execute();
	$cursor->closeCursor();
	return true ;
}

function update_admin($mail, $firstname, $name, $phone, $id) {
	$query = "UPDATE " . _TABLE__ADMIN_USERS . " 
	SET mail = :mail,
	firstname = :firstname,
	name = :name,
	phone = :phone 
	WHERE id = :id";

	global $connexion;


	$cursor = $connexion->prepare($query);

	$cursor->bindValue(':mail', $mail, PDO::PARAM_STR);
	$cursor->bindValue(':firstname', $firstname, PDO::PARAM_STR);
	$cursor->bindValue(':name', $name, PDO::PARAM_STR);
	$cursor->bindValue(':phone', $phone, PDO::PARAM_STR);
	$cursor->bindValue(':id', $id, PDO::PARAM_STR);

	$cursor->execute();
	$cursor->closeCursor();
	return true ;
}

function delete_admin($id) {
	$admin = get_one($id);

	if($_SESSION['ADMIN-USER']['statut'] < $admin->statut) {
		$query = "DELETE FROM nomduprojet_admin_users WHERE id = :id";
		
		global $connexion;

		$cursor = $connexion->prepare($query);

		$cursor->bindValue(':id', $id, PDO::PARAM_INT);
		$cursor->execute();
		$cursor->closeCursor();
		return true ;
	}

}

function get_statuts() {
	$query = "SELECT * FROM " . _TABLE__ADMIN_STATUTS . " WHERE type = 'admin'";

	$list = select_no_param($query);

	return $list ;
}
?>