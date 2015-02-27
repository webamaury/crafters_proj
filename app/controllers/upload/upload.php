<?php
class uploadController extends CoreController {
	
	function __construct($arrayCss, $arrayJs, $notices) {
		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($arrayCss, $arrayJs, $notices) ;
	}
	
	function main($arrayCss, $arrayJs, $notices) {
	
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		include_once(_APP_PATH . 'models/class.product.php');
		$ClassProduct = new ClassProducts();

		include_once(_APP_PATH . 'models/class.users.php');
		$ClassUser = new ClassUsers();

		$ClassUser->user_id_product = $_SESSION[_SES_NAME]['id'];
		$lastUploads = $ClassUser->getProductOfUser(4, $ClassUser->user_id_product);
		foreach ($lastUploads as $lastUpload) {
			$lastUpload->user_username = $_SESSION[_SES_NAME]['username'];
			$ClassProduct->product_id = $lastUpload->product_id;
			$nb_like = $ClassProduct->numberOfLike();
			$lastUpload->nb_like = $nb_like->nb_like;
			if ($lastUpload->nb_like > 0) {
				$lastUpload->name_likes = $ClassProduct->getUsersWhoLiked();
				if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] === true) {
					$ClassProduct->user_id = $_SESSION[_SES_NAME]["id"];
					$lastUpload->did_i_like = $ClassProduct->didILike();
				}
			}
		}

		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$CssToLoad = array('bootstrap-css', 'font-awesome', 'momo', 'custom2');
		$JsToLoad = array('jquery', 'bootstrap-js', 'jquery.form', 'list.js', 'panier.js', 'addproduct.js');
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Upload");
		DEFINE("_METADESCRIPTION", "Upload");
		
		
		##############################################################
		##	VUE														##
		##############################################################
		include('../app/views/upload/display.php');
	}
	
	function upload_ajax($arrayCss, $arrayJs, $notices) {
	
		############ Configuration ##############
		$thumb_square_size 		= 360; //Thumbnails will be cropped to 360x360 pixels
		$max_image_size 		= 800; //Maximum image size (height and width)
		$thumb_prefix			= "thumb_"; //Normal thumb Prefix
		$destination_folder		= _WWW_PATH . 'uploads/products/'; //upload directory ends with / (slash)
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
					echo '<div align="center">';
					echo '<img id="img_output" src="uploads/products/'.$thumb_prefix . $new_file_name.'" alt="Thumbnail">';
					echo '</div>';
				}
				
				imagedestroy($image_res); //freeup memory
			}
		}
		
	}
	
	function submitCraft() {
		include_once _APP_PATH . 'models/class.product.php';
		$classProducts = new ClassProducts();
		
		$classProducts->name 			= $_POST['name'];
		$classProducts->descr 		= $_POST['description'];
		$classProducts->status		= $_POST['radio_public_private'];
		$classProducts->img_url		= $_POST['img'];

		$lastId = $classProducts->insertNew();
		
		header('location:index.php?module=fiche&product=' . $lastId);
	}
	
}

?>