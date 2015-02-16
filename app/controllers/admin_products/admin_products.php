<?php
	
	class productsController extends CoreControlers {
		
		function __construct($arrayTools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.product.php';
			$products = new ClassProducts();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$products->product_id = $_GET['id'];
				if($products->deleteProduct()) {
					$notices->createNotice('success', 'Product deleted');
					header('location:index.php?module=products');exit();
				}
				else {
					$notices->createNotice('danger', 'Impossible to delete !');
					header('location:index.php?module=products');exit();
				}
			} else if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {

			$adminUsers->mail = $_POST['mail'];
			$adminUsers->password = md5($_POST['password']);
			$adminUsers->firstname = $_POST['firstname'];
			$adminUsers->name = $_POST['name'];
			$adminUsers->phone = $_POST['phone'];
			$adminUsers->statut = $_POST['statut'];

			if ($adminUsers->create_admin()) {
				$notices->createNotice('success', 'Admin added');
				header('location:index.php?module=adminUsers');
				exit();
			} else {
				$notices->createNotice("danger", "error while adding new admin");
				header("location:index.php?module=adminUsers");
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'modifier') {

				$products->product_id 				= $_GET['id'];
				$products->product_name				= $_POST['name'];
				$products->product_description 		= $_POST['description'];
				$products->product_status 			= $_POST['statut'];

	//						echo $_POST['statut']."<br>";
	//						echo $adminUsers->statut ; exit();	
				
				if($products->updateProduct()) {
					$notices->createNotice('success', 'Product updated');
					header('location:index.php?module=products&action=form&id='.$_GET['id']);exit();
				}
				else {
					$notices->createNotice('danger', 'erreur modif');
					header('location:index.php?module=products&action=form&id='.$_GET['id']);exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$products->product_id = $_GET['id'];
					$item = $products->get0ne();
					//var_dump($item); exit();
					if(empty($item)) {
						$notices->createNotice('danger', 'Unknown message !');
						header('location:index.php?module=products');exit();
					}
					$statuts = $products->getStatuts();

				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
				$stylesToLoad = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Admin product");
				DEFINE("_METADESCRIPTION", "Admin product");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_products/form.php');
			}
			else if((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] == 'list')) {
				$items = $products->getList();
				//$items = $adminUsers;
				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
				$stylesToLoad = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Admin product");
				DEFINE("_METADESCRIPTION", "Admin product");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_products/display.php');
			}
			else if (isset($_POST['action']) && $_POST['action'] == 'ajax_display_product_fiche') {
					$products->product_id = $_POST['id'];
					$ajaxItem = $products->getOneArray();
					$ajaxItem = json_encode($ajaxItem);
					echo $ajaxItem;
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_delete_avatar') {
					if(unlink(_WWW_PATH . $_POST['img_url'])) {
						$products->product_id=$_POST["product_id"];
						if($products->deleteAddressImg()){
							echo true;
						}
					}
					else {
						echo false;
					}
			} else if (isset($_POST['action']) && $_POST['action'] == 'uploadAjax') {
	
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
							$image_url = 'uploads/products/'.$thumb_prefix . $new_file_name;
							if ($products->updateImage($image_url, $_GET["product"])) {
							/* We have succesfully resized and created thumbnail image
							We can now output image to user's browser or store information in the database*/
							echo '<div align="center">';
							echo '<img id="img_output" src="../uploads/products/'.$thumb_prefix . $new_file_name.'" alt="Thumbnail">';
							echo '</div>';
							}

						}
						imagedestroy($image_res); //freeup memory
	
					}
					
				}
			}
		
		}
	}
?>