<?php

/**
 * Class ClassCommandes
 */
class ClassCommandes extends CoreModels
{
	public function insertCommande() {
		$query = "INSERT INTO " . _TABLE__COMMANDES . "
		(user_id_order, order_price)
		VALUES
		(:user_id, :price)";

		$cursor = $this->connexion->prepare($query);

		$cursor->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
		$cursor->bindValue(':price', $this->price, PDO::PARAM_STR);

		$return = $cursor->execute();
		if($return == true) {
			$return = $this->connexion->lastInsertId();
		}
		$cursor->closeCursor();

		if($return != false) {
			$return = $this->insertProductsCommande($this->products, $return);
		}


		return $return;
	}
	private function insertProductsCommande($products, $order_id)
	{
		foreach ($products as $key => $product) {
			$query = "INSERT INTO " . _TABLE__COMMANDES_PRODUITS . "
			(product_id, order_id, product_order_quantity, product_order_size)
			VALUES
			(:product_id, :order_id, :product_order_quantity, :product_order_size)";
			//var_dump($_SESSION, $products, $product, $query, $key, $order_id, $product['quantity'], $product['size']);
			$cursor = $this->connexion->prepare($query);

			$cursor->bindValue(':product_id', $key, PDO::PARAM_INT);
			$cursor->bindValue(':order_id', $order_id, PDO::PARAM_INT);
			$cursor->bindValue(':product_order_quantity', $product['quantity'], PDO::PARAM_INT);
			$cursor->bindValue(':product_order_size', $product['size'], PDO::PARAM_STR);

			$return = $cursor->execute();

			if($return == false) {
				return false;
			}
		}
		return $return;

	}
}
?>