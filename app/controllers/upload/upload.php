<?php
class uploadController extends CoreControlers {
	
	function __construct($array_tools, $notices) {
		if(!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main' ;
		}
		else if(isset($_POST['action'])) {
			$method = $_POST['action'];
		}

		$this->$method($array_tools, $notices) ;
	}
	
	function main($array_tools, $notices) {
	
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		
		
		
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$tools_to_load = array('bootstrap-css', 'font-awesome');
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Upload");
		DEFINE("_METADESCRIPTION", "Upload");
		
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once('../app/views/upload/display.php');

	}
	
	function upload_ajax($array_tools, $notices) {
	
		############ Configuration ##############
		$thumb_square_size 		= 360; //Thumbnails will be cropped to 360x360 pixels
		$max_image_size 		= 800; //Maximum image size (height and width)
		$thumb_prefix			= "thumb_"; //Normal thumb Prefix
		$destination_folder		= '/Applications/MAMP/htdocs/crafters_proj/www/uploads/'; //upload directory ends with / (slash)
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
					echo '<img id="img_output" src="uploads/'.$thumb_prefix . $new_file_name.'" alt="Thumbnail">';
					echo '</div>';
				}
				
				imagedestroy($image_res); //freeup memory
			}
		}
		
	}
	
	function submit_pay() {
		include_once _APP_PATH . 'models/class.product.php';
		$product = new classProduct();
		
		$product->name 			= $_POST['name'];
		$product->descr 		= $_POST['description'];
		$product->status		= $_POST['radio_public_private'];
		$product->type			= $_POST['radio_tatoo_stickers'];
		$product->img_url		= $_POST['img'];

		$product->insert_new();
		
		header('location:index.php?module=summary');
	}
	
	function submit_save() {

		include_once _APP_PATH . 'models/class.product.php';
		$product = new classProduct();
		
		$product->name 			= $_POST['name'];
		$product->descr 		= $_POST['description'];
		$product->status		= $_POST['radio_public_private'];
		$product->type			= $_POST['radio_tatoo_stickers'];
		$product->img_url		= $_POST['img'];

		$product->insert_new();

		header('location:index.php?module=dashboard');
	}
}

?>