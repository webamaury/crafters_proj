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

	function upload_ajax($arrayTools, $notices)
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
}

?>