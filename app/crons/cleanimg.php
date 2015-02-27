<?php

$connexion = new PDO ();
$connexion->exec("SET CHARACTER SET utf8");

$path_to_modules = '../../www/uploads/products';
if ($handle = opendir( $path_to_modules ))
{
	$i = 0;
	foreach(scandir($path_to_modules) as $img) {
		if ($img != '.' && $img != '..' && preg_match("#^thumb#", $img)) {
			$arrayImg[$i] = $img;
			$i++;
		}
	}

	foreach ($arrayImg as $img) {
		$query = "SELECT *
		FROM  crafters_product
		WHERE product_img_url = 'uploads/products/" . $img . "'";

		$cursor = $connexion->prepare($query);

		$cursor->execute();
		$cursor->setFetchMode(PDO::FETCH_OBJ);
		$return = $cursor->fetchAll();
		if (count($return) == 0){
			echo $img."<br/>";
			unlink('../../www/uploads/products/' . $img);
		}
	}






}

?>