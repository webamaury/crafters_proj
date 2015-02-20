<?php
	
	class usersController extends CoreControlers {
		
		function __construct($arrayTools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.users.php';
			$users = new ClassUsers();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$users->user_id = $_GET['id'];
				if($users->deleteUser()) {
					$notices->createNotice('success', 'Users deleted');
					header('location:index.php?module=users');exit();
				}
				else {
					$notices->createNotice('danger', 'Impossible to delete !');
					header('location:index.php?module=users');exit();
				}
			}
			else if(isset($_POST['action']) && $_POST['action'] == "send_mail") {
	
				$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.header.htm');
				$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.contact.htm');
				$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.footer.htm');
				
				// On remplace les infos personnelles
				$tpl = str_replace("%CONTENT%", 	stripslashes($_POST['content']),		 		$tpl);
				$tpl = str_replace("%SITE_NAME%", 	_SITE_NAME, 									$tpl);
			
			
			
				if(send_mail($tpl, $_SESSION['ADMIN-USER']['firstname'].$_SESSION['ADMIN-USER']['name'], $_SESSION['ADMIN-USER']['mail'], $_POST['input_mail'], $_POST['subject'])) {
					$notices->createNotice('success', 'Message sent');
					header('location:index.php?module=users');exit();
				}
				else {
					$notices->createNotice('danger', 'Error while sending the message !');
					header('location:index.php?module=users');exit();
				}
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'modifier') {
				$users->user_id 			= $_GET['id'];
				$users->user_mail 			= $_POST['mail'];
				$users->user_firstname 		= $_POST['firstname'];
				$users->user_name 			= $_POST['name'];
				$users->user_username 		= $_POST['username'];
				$users->user_phone 			= $_POST['phone'];
				$users->user_birthday		= $_POST['birthday'];
				$users->user_status 		= $_POST['statut'];
				$users->user_description	= $_POST['descr_month'];
				if (isset($_POST['checkbox_month']) && $_POST['checkbox_month'] == 1) {
					$users->user_month = $_POST['checkbox_month'];
					$users->clearUserMonth();
				} else {
					$users->user_month = 0;
				}
				
	//						echo $_POST['statut']."<br>";
	//						echo $adminUsers->statut ; exit();	
				if($users->updateUser()) {
					$notices->createNotice('success', 'User modifié');
					header('location:index.php?module=users&action=form&id='.$_GET['id']);exit();
				}
				else {
					$notices->createNotice('danger', 'erreur modif');
					header('location:index.php?module=users&action=form&id='.$_GET['id']);exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$users->user_id = $_GET['id'];
					$item = $users->getOne();
					if(empty($item)) {
						$notices->createNotice('danger', 'Unknown user !');
						header('location:index.php?module=users');exit();
					}

				$statuts = $users->getStatuts();

				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
				$stylesToLoad = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "User");
				DEFINE("_METADESCRIPTION", "User");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_users/form.php');
			}
			else if((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] == 'list')) {
				$items = $users->getList();
				
				//$items = $adminUsers;
				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
				$stylesToLoad = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Users");
				DEFINE("_METADESCRIPTION", "Users");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_users/display.php');
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_display_user_fiche') {
					$users->user_id = $_POST['id'];
					$ajaxItem = $users->getOneArray();
					$ajaxItem['address'] = $users->getOneArrayAddress(); 
					if(empty($ajaxItem['address'])) {
						$ajaxItem['address']['address_numberstreet'] = '';
						$ajaxItem['address']['address_town'] = '';
						$ajaxItem['address']['address_zipcode'] = '';
						$ajaxItem['address']['address_country'] = '';
					}
					$ajaxItem = json_encode($ajaxItem);
					echo $ajaxItem;
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_delete_avatar') {
					if(unlink(_WWW_PATH . $_POST['img_url'])) {
						$users->user_id=$_POST["user_id"];
						if($users->deleteAddressImg()){
							echo true;
						}
					}
					else {
						echo false;
					}
			}
			else if (isset($_POST['action']) && $_POST['action'] == 'uploadAjax') {
	
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
							$image_url = 'uploads/users/'.$thumb_prefix . $new_file_name;
							if ($users->updateImage($image_url, $_GET["user"])) {
							/* We have succesfully resized and created thumbnail image
							We can now output image to user's browser or store information in the database*/
							echo '<div align="center">';
							echo '<img id="img_output" src="../uploads/users/'.$thumb_prefix . $new_file_name.'" alt="Thumbnail">';
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