<?php
class profileController extends CoreControlers {
		
	function __construct($arrayTools, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($arrayTools, $notices) ;

	}

	function main($arrayTools, $notices) {

		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new ClassProducts();

		if (isset($_GET['user'])) {
			if (isset($_SESSION[_SES_NAME]['id']) && $_SESSION[_SES_NAME]['id'] == $_GET['user']) {
				header('location:index.php?module=profile'); exit();
			}
			$ClassUser->user_id = $_GET['user'];
			$myprofile = false;
		} else if (isset($_SESSION[_SES_NAME]['id'])) {
			$ClassUser->user_id = $_SESSION[_SES_NAME]['id'];
			$myprofile = true;
		} else {
			$notices->createNotice('danger', 'You must be connected to access to this page');
			header('location:index.php');exit();
		}
		$user = $ClassUser->getOne();

		$products = $ClassUser->getProductOfUser('9', $ClassUser->user_id);
		foreach ($products as $product) {
			$ClassProduct->product_id = $product->product_id;
			$nb_like = $ClassProduct->numberOfLike();
			$product->nb_like = $nb_like->nb_like;
			if ($product->nb_like > 0) {
				$product->name_likes = $ClassProduct->getUsersWhoLiked();
				if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] === true) {
					$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];
					$product->did_i_like = $ClassProduct->didILike();
				}
			}
		}

		$orders = $ClassUser->getOrdersOfUser('9', $ClassUser->user_id);
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$toolsToLoad = array('bootstrap-css', 'font-awesome');
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Crafters | Profile ".$user->user_username);
		DEFINE("_METADESCRIPTION", "Crafters, Tattoo and stickers designer");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/profile/display.php');
	}

	function update($arrayTools, $notices)
	{
		if (!isset($_POST) || !isset($_SESSION[_SES_NAME]['id'])) {
			header('location:index.php'); exit();
		} else if (!isset($_POST['firstname']) || !isset($_POST['name']) || !isset($_POST['username']) || !isset($_POST['mail']) || !isset($_POST['name'])) {
			$notices->createNotice("danger", "Please complete all required field.");
			header("location:index.php?module=profile"); exit();
		} else {
			//var_dump($_POST);
			include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();

			$ClassUser->user_firstname = $_POST['firstname'];
			$ClassUser->user_name = $_POST['name'];
			$ClassUser->user_username = $_POST['username'];
			$ClassUser->user_mail = $_POST['mail'];
			$ClassUser->user_phone = $_POST['phone'];
			$ClassUser->user_birthday = $_POST['birthday'];
			$ClassUser->user_status = 1;
			$ClassUser->user_id = $_SESSION[_SES_NAME]['id'];

			$return = $ClassUser->updateUser();

			if ($return == true) {
				$_SESSION[_SES_NAME]['firstname'] = $_POST['firstname'];
				$_SESSION[_SES_NAME]['name'] = $_POST['name'];
				$_SESSION[_SES_NAME]['username'] = $_POST['username'];
				$_SESSION[_SES_NAME]['mail'] = $_POST['mail'];

				$notices->createNotice("success", "Your information has been successfully modified.");
				header('location:index.php?module=profile'); exit();
			}
		}
	}

}

?>