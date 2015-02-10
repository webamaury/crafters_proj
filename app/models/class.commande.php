<?php

/**
 * Class ClassCommandes
 */
class ClassCommandes extends CoreModels
{
	public function insertCommande() {
		$query = "INSERT INTO " . _TABLE__COMMANDES . "
		(user_id_order, order_hash, order_price)
		VALUES
		(:user_id, :order_hash, :price)";
		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$cursor->bindValue(':price', $this->price, PDO::PARAM_STR);
		$cursor->bindValue(':order_hash', $this->order_hash, PDO::PARAM_STR);

		$return = $cursor->execute();

		if($return == true) {
			$return = $this->connexion->lastInsertId();
		}
		$cursor->closeCursor();

		if($return != false) {
			$this->insertProductsCommande($this->products, $return);
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

}
?>