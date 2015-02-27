<?php
class profileController extends CoreController {
		
	function __construct($arrayCss, $arrayJs, $notices) {

		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}
		$this->nb_by_page = 8;

		$this->$method($arrayCss, $arrayJs, $notices) ;

	}

	function main($arrayCss, $arrayJs, $notices) {

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

		if (empty($user)) {
			header('location:index.php');
		}
		if ($user->statut == 0) {
			header('location:index.php');
		}
		$limit = '0, ' . $this->nb_by_page;
		if ($myprofile == true) {
			$products = $ClassUser->getMyProducts($limit, $ClassUser->user_id);
		} else {
			$products = $ClassUser->getProductOfUser($limit, $ClassUser->user_id);
		}
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
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'jquery.form', 'list.js', 'loadmore.js', 'panier.js', 'addavatar.js');
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

	function update($arrayCss, $arrayJs, $notices)
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
			$ClassUser->user_phone = $_POST['phone'];
			$ClassUser->user_birthday = $_POST['birthday'];
			$ClassUser->user_status = 1;
			$ClassUser->user_id = $_SESSION[_SES_NAME]['id'];

			if($_POST['mail'] != $_SESSION[_SES_NAME]['mail']) {
				$ClassUser->user_mail = $_POST['mail'];
				if (!$ClassUser->mailUnique()) {
					$notices->createNotice('danger', 'This Mail address is already use!');
					header("location:index.php?module=profile&where=infos"); exit();
				}
				$ClassUser->user_newmail_hash = substr(strtolower(md5(time() . session_id())), 0, 8);;
				$changeMail = true;
			} else {
				$ClassUser->user_mail = "";
				$ClassUser->user_newmail_hash = "";
				$changeMail = false;

			}
			//Si le username est modifié, vérification de l'unicité
			if($_POST['username'] != $_SESSION[_SES_NAME]['username']) {
				if (!$ClassUser->usernameUnique()) {
					$notices->createNotice('danger', 'This username is already use!');
					header("location:index.php?module=profile&where=infos");
					exit();
				}
			}

			$return = $ClassUser->updateUserFront();

			if ($return == true) {
				$_SESSION[_SES_NAME]['firstname'] = $_POST['firstname'];
				$_SESSION[_SES_NAME]['name'] = $_POST['name'];
				$_SESSION[_SES_NAME]['username'] = $_POST['username'];
				$_SESSION[_SES_NAME]['mail'] = $_POST['mail'];

				if ($changeMail == true) {
					//SEND MAIL CONFIRMATION
					$url = _PATH_FOLDER . "index.php?module=profile&action=newmail&hh=" . $ClassUser->user_newmail_hash;

					$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.confirm.htm');

					// On remplace les infos personnelles
					$tpl = str_replace("%URL%", $url, $tpl);

					$this->send_mail($tpl,
						_SITE_NAME,
						'amaury.gilbon@gmail.com',
						$_POST['mail'],
						'Confirm e-mail modification');
				}
				$notices->createNotice("success", "Your information has been successfully modified.");
				header('location:index.php?module=profile'); exit();
			}
		}
	}
	function newmail($arrayCss, $arrayJs, $notices)
	{
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();

		$ClassUser->user_newmail_hash = $_GET['hh'];

		$newmail = $ClassUser->getNewMail();
		var_dump($newmail);
		$return = $ClassUser->confirmNewMail();

		if (isset($_SESSION[_SES_NAME]['mail'])) {
			$_SESSION[_SES_NAME]['mail'] = $newmail->user_newmail;
		}

		$notices->createNotice("success", "You mail has been succesfully modified.");
		header('location:index.php?module=profile');exit();

	}

	function upload_ajax($arrayCss, $arrayJs, $notices)
	{
		############ Configuration ##############
		$thumb_square_size 		= 360; //Thumbnails will be cropped to 360x360 pixels
		$max_image_size 		= 800; //Maximum image size (height and width)
		$thumb_prefix			= "thumb_"; //Normal thumb Prefix
		$destination_folder		= _WWW_PATH . 'uploads/users/'; //upload directory ends with / (slash)
		$jpeg_quality 			= 90; //jpeg quality
		##########################################

		//continue only if $_POST is set and it is a Ajax request
		if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

			// check $_FILES['ImageFile'] not empty
			if(!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])){
				die('Image file is Missing!'); // output error when above checks fail.
			}

			//uploaded file info we need to proceed
			$image_name = $_FILES['image_file']['name']; //file name
			$image_size = $_FILES['image_file']['size']; //file size
			$image_temp = $_FILES['image_file']['tmp_name']; //file temp

			$image_size_info 	= getimagesize($image_temp); //get image size

			if($image_size_info){
				$image_width 		= $image_size_info[0]; //image width
				$image_height 		= $image_size_info[1]; //image height
				$image_type 		= $image_size_info['mime']; //image type
			}else{
				die("Make sure image file is valid!");
			}

			//switch statement below checks allowed image type
			//as well as creates new image from given file
			switch($image_type){
				case 'image/png':
					$image_res =  imagecreatefrompng($image_temp); break;
				case 'image/jpeg': case 'image/pjpeg':
				$image_res = imagecreatefromjpeg($image_temp); break;
				default:
					$image_res = false;
			}

			if($image_res){
				//Get file extension and name to construct new file name
				$image_info = pathinfo($image_name);
				$image_extension = strtolower($image_info["extension"]); //image extension
				$image_name_only = strtolower($image_info["filename"]);//file name only, no extension

				//create a random name for new image (Eg: fileName_293749.jpg) ;
				$new_file_name =  md5(rand(0, 9999999999)) . '.' . $image_extension;

				//folder path to save resized images and thumbnails
				$thumb_save_folder 	= $destination_folder . $thumb_prefix . $new_file_name;
				$image_save_folder 	= $destination_folder . $new_file_name;

				//call normal_resize_image() function to proportionally resize image
				if($this->normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
				{
					//call crop_image_square() function to create square thumbnails
					if(!$this->crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
					{
						die('Error Creating thumbnail');
					}

					/* We have succesfully resized and created thumbnail image
					We can now output image to user's browser or store information in the database*/
					echo '<img id="img_output" src="uploads/users/'.$thumb_prefix . $new_file_name.'" class="img-circle img-responsive" style="float:right;" alt="Thumbnail">';
				}
				imagedestroy($image_res); //freeup memory
			}
		}
	}
	function update_img_url_ajax()
	{
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();

		$ClassUser->img_url = $_POST['img_url'];
		$ClassUser->user_id = $_SESSION[_SES_NAME]['id'];

		$return = $ClassUser->updateImgUrl();

		echo $return;
	}
	function deleteCraft($arrayCss, $arrayJs, $notices)
	{
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new ClassProducts();

		$ClassProduct->product_id = $_GET['product'];
		$product = $ClassProduct->get0ne();

		if (!isset($_SESSION[_SES_NAME]['id']) || $product->user_id_product != $_SESSION[_SES_NAME]['id']) {
			header('location:index.php'); exit();
		}


		$return = $ClassProduct->deleteProduct();

		if ($return == true) {
			unlink(_WWW_PATH . $product->product_img_url);

			$notices->createNotice("success", "Your craft has been successfully deleted!");
			header('location: index.php?module=profile'); exit();
		}

	}

	function updatePassword($arrayCss, $arrayJs, $notices)
	{
		if (!isset($_POST) || !isset($_SESSION[_SES_NAME])) {
			header('location:index.php');
		}
		//var_dump($_POST);
		if (md5($_POST['current_password']) != $_SESSION[_SES_NAME]['password']) {
			sleep(1);
			$notices->createNotice("danger", "Your current password is wrong!");
			header('location:index.php?module=profile&where=infos');
			exit();
		}
		if ($_POST['new_password'] != $_POST['confirm_password']) {
			$notices->createNotice("danger", "New password doesn't match with its confirmation!");
			header('location:index.php?module=profile&where=infos');
			exit();
		}
		if (md5($_POST['new_password']) == $_SESSION[_SES_NAME]['password']) {
			$notices->createNotice("danger", "Your new password is identical to the old one.");
			header('location:index.php?module=profile&where=infos');
			exit();
		}
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();
		$ClassUser->user_password = md5($_POST['new_password']);
		$ClassUser->user_id = $_SESSION[_SES_NAME]['id'];

		$return = $ClassUser->updatePassword();

		if (!$return) {
			$notices->createNotice("danger", "Problem while updating your password. Please try again later.");
			header('location:index.php?module=profile&where=infos');
			exit();
		}

		$_SESSION[_SES_NAME]['password'] = md5($_POST['new_password']);
		$notices->createNotice("success", "Your password has been succesfully updated!");
		header('location:index.php?module=profile&where=infos');
		exit();
	}

	function forgotpwd()
	{
		if (!isset($_POST) || !isset($_POST['email']) || empty($_POST['email'])) {
			header('location:index.php');
			exit();
		}
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();

		$ClassUser->user_forgot_hash = md5(time() . session_id());
		$ClassUser->user_mail = $_POST['email'];
		$return = $ClassUser->forgotInputHash();

		$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.forgot.htm');

		$url = _PATH_FOLDER . 'index.php?module=profile&action=forgotpwdsecond&hash=' . $ClassUser->user_forgot_hash;
		// On remplace les infos personnelles
		$tpl = str_replace("%URL%", $url, $tpl);

		$this->send_mail($tpl,
			_SITE_NAME,
			'amaury.gilbon@gmail.com',
			$_POST['email'],
			'Forgot your password on ' . _SITE_NAME);

	}
	function forgotpwdsecond($arrayCss, $arrayJs, $notices)
	{
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		if (!isset($_GET['hash']) || empty($_GET['hash'])) {
			header('location:index.php');exit();
		}
		include_once(_APP_PATH . 'models/class.product.php'); $ClassUser = new ClassUsers();

		$ClassUser->user_forgot_hash = $_GET['hash'];
		$return = $ClassUser->hashExist();

		if ($return == false) {
			sleep(2);
			header('location:index.php');exit();
		}

		//var_dump($return);

		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'jquery.form', 'list.js', 'loadmore.js', 'panier.js', 'addavatar.js');

		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Crafters | Forgot password");
		DEFINE("_METADESCRIPTION", "Crafters, Tattoo and stickers designer");

		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/autres/forgot.php');
	}
	function newPassword($arrayCss, $arrayJs, $notices)
	{
		if (!isset($_POST) || !isset($_POST['hash']) || empty($_POST['hash'])) {
			header('location:index.php');
			exit();
		}
		//var_dump($_POST);
		include_once(_APP_PATH . 'models/class.users.php'); $ClassUser = new ClassUsers();

		$ClassUser->user_forgot_hash = $_POST['hash'];
		$return = $ClassUser->hashExist();

		if ($return == false) {
			sleep(2);
			header('location:index.php');exit();
		}

		if (!isset($_POST['new_password']) || !isset($_POST['confirm_password'])) {
			$notices->createNotice("danger", "Complete all required field!");
			header('location:index.php?module=profile&action=forgotpwdsecond&hash' . $_POST['hash']);
			exit();
		}
		if ($_POST['new_password'] != $_POST['confirm_password']) {
			$notices->createNotice("danger", "Passwords are not identical!");
			header('location:index.php?module=profile&action=forgotpwdsecond&hash' . $_POST['hash']);
			exit();
		}

		$ClassUser->user_password = md5($_POST['new_password']);
		$return = $ClassUser->updatePasswordWithHash();

		if ($return == false) {
			$notices->createNotice("danger", "Problem while changing your password. Please try again later.");
			header('location:index.php?module=profile&action=forgotpwdsecond&hash' . $_POST['hash']);
			exit();
		}

		$ClassUser->cleanHash();

		$notices->createNotice("success", "You password has been successfully updated. You can now sing in.");
		header('location:index.php');
		exit();

	}

	/**
	 * @param $arrayCss
	 * @param $arrayJs
	 * @param $notices
	 */
	function ajax_more($arrayCss, $arrayJs, $notices)
	{
		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new ClassProducts();
		include_once(_APP_PATH . 'models/class.users.php'); $ClassUser = new ClassUsers();

		$min = ($_POST['page'] - 1) * $this->nb_by_page;
		$limit = $min . ',' . $this->nb_by_page;


		if(!isset($_POST['user']) || empty($_POST['user'])) {
			echo false; exit();
		} else if (isset($_SESSION[_SES_NAME]['id']) && $_POST['user'] == $_SESSION[_SES_NAME]['id']) {
			$products = $ClassUser->getMyProducts($limit, $_POST['user']);
		} else {
			$products = $ClassUser->getProductOfUser($limit, $_POST['user']);
		}

		if (!empty($products)) {
			foreach ($products as $product) {
				$ClassProduct->product_id = $product->product_id;
				$nb_like = $ClassProduct->numberOfLike();
				$product->nb_like = $nb_like->nb_like;
				if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
					$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];
					$product->did_i_like = $ClassProduct->didILike();
				} else {
					$product->did_i_like = 2;
				}

			}

			$json = json_encode($products);
			echo $json;
			exit();
		} else {
			echo 'no more'; exit();
		}
	}
}

?>