<?php

/**
 * Class ClassCommandes
 */
class ClassCommandes extends CoreModel
{
	public function insertCommande() {
		$query = "INSERT INTO " . _TABLE__COMMANDES . "
		(user_id_order, order_hash, order_price, order_custom, order_delivery)
		VALUES
		(:user_id, :order_hash, :price, :order_custom, :order_delivery)";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$cursor->bindValue(':price', $this->price, PDO::PARAM_STR);
		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);
		$cursor->bindValue(':order_custom', $this->order_custom, PDO::PARAM_STR);
		$cursor->bindValue(':order_delivery', $this->order_delivery, PDO::PARAM_INT);

		$return = $cursor->execute();

		if($return == true) {
			$return = $this->connexion->lastInsertId();
		}
		$cursor->closeCursor();

		if($return != false) {
			$this->insertProductsCommande($this->products, $return);
			$this->insertAdresseCommande($this->ad_numberstreet,$this->ad_zipcode,$this->ad_city,$this->ad_more,$this->ad_firstname,$this->ad_name,$this->ad_status, $return);
		}

		return $return;
	}
	private function insertProductsCommande($products, $order_id)
	{
		foreach ($products as $key => $product) {
			$query = "INSERT INTO " . _TABLE__COMMANDES_PRODUITS . "
			(product_id, order_id, product_order_quantity, product_order_size, product_order_type)
			VALUES
			(:product_id, :order_id, :product_order_quantity, :product_order_size, :product_order_type)";

			$cursor = $this->connexion->prepare($query);

			$cursor->bindValue(':product_id', $key, PDO::PARAM_INT);
			$cursor->bindValue(':order_id', $order_id, PDO::PARAM_INT);
			$cursor->bindValue(':product_order_quantity', $product['quantity'], PDO::PARAM_INT);
			$cursor->bindValue(':product_order_size', $product['size'], PDO::PARAM_STR);
			$cursor->bindValue(':product_order_type', $product['type'], PDO::PARAM_STR);

			$return = $cursor->execute();

			if($return == false) {
				return false;
			}
		}
		return $return;

	}
	private function insertAdresseCommande($address_numberstreet, $address_zipcode, $address_town, $address_more, $address_firstname, $address_name, $address_status, $crafters_order_order_id)
	{
		$query = "INSERT INTO " . _TABLE__ADDRESS . "
		(address_numberstreet, address_town, address_zipcode, address_more, address_firstname, address_name, address_status, crafters_order_order_id)
		VALUES
		(:address_numberstreet, :address_town, :address_zipcode, :address_more, :address_firstname, :address_name, :address_status, :crafters_order_order_id)";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':address_numberstreet', $address_numberstreet, PDO::PARAM_STR);
		$cursor->bindValue(':address_town', $address_town, PDO::PARAM_STR);
		$cursor->bindValue(':address_zipcode', $address_zipcode, PDO::PARAM_STR);
		$cursor->bindValue(':address_more', $address_more, PDO::PARAM_STR);
		$cursor->bindValue(':address_firstname', $address_firstname, PDO::PARAM_STR);
		$cursor->bindValue(':address_name', $address_name, PDO::PARAM_STR);

		$cursor->bindValue(':address_status', $address_status, PDO::PARAM_INT);
		$cursor->bindValue(':crafters_order_order_id', $crafters_order_order_id, PDO::PARAM_INT);

		$return = $cursor->execute();

		return $return;
	}
	function get_commande()
	{
		$query = "SELECT * FROM " . _TABLE__COMMANDES . " WHERE order_id = :order_id";
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':order_id', $this->order_id, PDO::PARAM_INT);
		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;
	}
	function getAdressesCommande($order_id)
	{
		$query = "SELECT * FROM " . _TABLE__ADDRESS . " WHERE crafters_order_order_id = :order_id ORDER BY address_status ASC";
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':order_id', $order_id, PDO::PARAM_INT);
		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetchAll();
		$cursor->closeCursor();

		return $return;
	}
	function getCommandeWithHash()
	{
		$query = "SELECT * FROM " . _TABLE__COMMANDES . " WHERE order_hash = :order_hash LIMIT 0,1";
		$cursor = $this->connexion->prepare($query);
		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);
		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetch();
		$cursor->closeCursor();

		return $return;
	}
	public function statusPayed()
	{
		$query = "UPDATE " . _TABLE__COMMANDES . "
		SET order_status = 1
		WHERE order_id = :order_id";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':order_id', $this->order_id, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}
	public function statusSend()
	{
		$query = "UPDATE " . _TABLE__COMMANDES . "
		SET order_status = 2
		WHERE order_hash = :order_hash";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}

	public function commandeDebug()
	{
		$query = "UPDATE " . _TABLE__COMMANDES . "
		SET order_custom = 'hello'
		WHERE order_id = 10";
		$cursor = $this->connexion->prepare($query);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}
	function paymentMode()
	{
		$query = "UPDATE " . _TABLE__COMMANDES . "
		SET order_payment_mode = :order_payment_mode
		WHERE order_id = :order_id";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':order_payment_mode', $this->order_payment_mode, PDO::PARAM_STR);
		$cursor->bindValue(':order_id', $this->order_id, PDO::PARAM_STR);

		$return = $cursor->execute();

		$cursor->closeCursor();

		return $return;
	}
}
?>