<?php

/**
 * Class AdminUsersController
 */
class adminUsersController extends CoreController {

	/**
	 * @param $arrayTools
	 * @param $notices
	 * @param $modules
	 */
	function __construct($arrayTools, $notices, $modules) {
		//include_once(_APP_PATH . 'models/lib.admin_users.php');
		include_once _APP_PATH . 'models/class.adminUsers.php';
		$adminUsers = new classAdminUsers();

		if (isset($_GET['action']) && $_GET['action'] === "delete") {
			$adminUsers->id = $_GET['id'];
			if ($adminUsers->delete_admin()) {
				$notices->createNotice('success', 'Admin deleted');
				header('location:index.php?module=adminUsers');
				exit();
			} else {
				$notices->createNotice('danger', 'Impossible to delete !');
				header('location:index.php?module=adminUsers');
				exit();
			}
		} else if (isset($_POST['action']) && $_POST['action'] === 'send_mail') {

			$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.header.htm');
			$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.contact.htm');
			$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.footer.htm');

			// On remplace les infos personnelles
			$tpl = str_replace("%CONTENT%", stripslashes($_POST['content']), $tpl);
			$tpl = str_replace("%SITE_NAME%", _SITE_NAME, $tpl);


			if ($this->send_mail($tpl,
				$_SESSION['ADMIN-USER']['firstname'] . $_SESSION['ADMIN-USER']['name'],
				$_SESSION['ADMIN-USER']['mail'],
				$_POST['input_mail'],
				$_POST['subject'])) {
				$notices->createNotice('success', 'Message sent');
				header('location:index.php?module=adminUsers');
				exit();
			} else {
				$notices->createNotice('danger', 'Error while sending the message !');
				header('location:index.php?module=adminUsers');
				exit();
			}
		} else if (isset($_POST['action']) && $_POST['action'] === 'modifier') {

			$adminUsers->id = $_GET['id'];
			$adminUsers->mail = $_POST['mail'];
			$adminUsers->firstname = $_POST['firstname'];
			$adminUsers->name = $_POST['name'];
			$adminUsers->phone = $_POST['phone'];
			if (isset($_POST['statut'])) {
				$adminUsers->statut = $_POST['statut'];
			} else {
				$adminUsers->statut = 1;
			}

			//						echo $_POST['statut']."<br>";
			//						echo $adminUsers->statut ; exit();

			if ($adminUsers->update_admin()) {
				$notices->createNotice('success', 'Admin modifié');
				header('location:index.php?module=adminUsers&action=form&id=' . $_GET['id']);
				exit();
			} else {
				$notices->createNotice('danger', 'erreur modif');
				header('location:index.php?module=adminUsers&action=form&id=' . $_GET['id']);
				exit();
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
		} else if (isset($_GET['action']) && $_GET['action'] === 'form') {
			if ((isset($_GET['id']) && $_GET['id'] == $_SESSION['ADMIN-USER']['id']) || (isset($_GET['id']) && $_SESSION['ADMIN-USER']['statut'] == 1)) {
				$adminUsers->id = $_GET['id'];
				$item = $adminUsers->getOne();
				if (empty($item)) {
					$notices->createNotice('danger', 'Unknown user !');
					header('location:index.php?module=adminUsers');
					exit();
				} else if ($_SESSION['ADMIN-USER']['statut'] === $item->statut && $_SESSION['ADMIN-USER']['id'] !== $item->id) {
					$notices->createNotice('danger', 'Impossible action bis !');
					header('location:index.php?module=adminUsers');
					exit();
				}
			} else if (isset($_GET['id'])) {
				$notices->createNotice('danger', 'Impossible action !');
				header('location:index.php?module=adminUsers');
				exit();
			}
			$statuts = $adminUsers->get_statuts();

			/*************************************************************
			**	APPEL TOOLS												**
			**************************************************************/
			$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
			$stylesToLoad = array("style");

			/*************************************************************
			**	VARIABLES LAYOUT										**
			**************************************************************/
			DEFINE("_METATITLE", "Admin user");
			DEFINE("_METADESCRIPTION", "Admin user");

			/*************************************************************
			**	VUE														**
			**************************************************************/
			include_once(_APP_PATH . 'views/admin_admin_users/form.php');
		} else if ((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] === 'list')) {
			$items = $adminUsers->get_list();

			//$items = $adminUsers;
			/*************************************************************
			**	APPEL TOOLS												**
			**************************************************************/
			$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
			$stylesToLoad = array("style");

			/*************************************************************
			**	VARIABLES LAYOUT										**
			**************************************************************/
			DEFINE("_METATITLE", "Admin users");
			DEFINE("_METADESCRIPTION", "Admin users");

			/*************************************************************
			**	VUE														**
			**************************************************************/
			include_once(_APP_PATH . 'views/admin_admin_users/display.php');
		} else if (isset($_POST['action']) && $_POST['action'] === 'ajax_display_admin_fiche') {
			$adminUsers->id = $_POST['id'];
			$ajaxItem = $adminUsers->get_one_array();

			if ($ajaxItem['admin_img_url'] == NULL) {
				$ajaxItem['admin_img_url'] = _ADMIN_PATH . 'img/avatar.jpg';
			}

			$ajaxItem = json_encode($ajaxItem);
			echo $ajaxItem;
		} else if (isset($_POST['action']) && $_POST['action'] === 'ajax_delete_avatar') {
			if (unlink(_ADMIN_PATH . 'img/photo_' . $_POST['id'] . '.jpg')) {
				echo true;
			} else {
				echo false;
			}
		} else if (isset($_POST['action']) && $_POST['action'] === 'ajax_update_password') {
			if ($_SESSION['ADMIN-USER']['id'] === $_POST['admin_id']) {
				if ($_POST['new_password'] === $_POST['confirm_password']) {
					if ($_SESSION['ADMIN-USER']['password'] === md5($_POST['current_password'])) {
						$adminUsers->id = $_POST['admin_id'];
						$adminUsers->password = md5($_POST['new_password']);
						$myreturn = $adminUsers->update_password();
						if ($myreturn) {
							$_SESSION['ADMIN-USER']['password'] = md5($_POST['new_password']);
							echo true;
						} else {
							echo "error_sql";
						}
					} else {
						echo "wrong_current";
					}
				} else {
					echo "wrong_confirm";
				}
			} else {
				echo "modif_impo";
			}
		} else if (isset($_POST['action']) && $_POST['action'] == 'uploadAjax') {

			############ Configuration ##############
			$thumb_square_size 		= 200; //Thumbnails will be cropped to 200 pixels
			$max_image_size 		= 800; //Maximum image size (height and width)
			$thumb_prefix			= "thumb_"; //Normal thumb Prefix
			$destination_folder		= _WWW_PATH . 'uploads/admins/'; //upload directory ends with / (slash)
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
						$image_url = 'uploads/admins/'.$thumb_prefix . $new_file_name;

						if ($adminUsers->updateImage($image_url, $_GET["admin"])) {

							$_SESSION["ADMIN-USER"]["img_url"] = $image_url;

							/* We have succesfully resized and created thumbnail image
							We can now output image to user's browser or store information in the database*/
							echo '<div align="center">';
							echo '<img id="img_output" class="img_avatar img-responsive img-circle center-block" src="' . _WWW_PATH . $image_url . '" alt="Thumbnail">';
							echo '</div>';
						}

					}
					imagedestroy($image_res); //freeup memory

				}

			}
		} else {

		}


	}
}

?>