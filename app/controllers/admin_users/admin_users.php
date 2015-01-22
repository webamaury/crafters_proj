<?php
	
	class usersController {
		
		function __construct($array_tools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.users.php';
			$users = new ClassUsers();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$users->user_id = $_GET['id'];
				if($users->deleteUser()) {
					$notices->create_notice('success', 'Users deleted');
					header('location:index.php?module=users');exit();
				}
				else {
					$notices->create_notice('danger', 'Impossible to delete !');
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
					$notices->create_notice('success', 'Message sent');
					header('location:index.php?module=users');exit();
				}
				else {
					$notices->create_notice('danger', 'Error while sending the message !');
					header('location:index.php?module=users');exit();
				}
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'modifier') {

				$users->user_id 			= $_GET['id'];				
				$users->user_mail 			= $_POST['mail'];
				$users->user_firstname 		= $_POST['firstname'];
				$users->user_name 			= $_POST['name'];
				$users->user_phone 			= $_POST['phone'];
				$users->user_birthday		= $_POST['birthday'];
				$users->user_status 		= $_POST['statut'];
				
	//						echo $_POST['statut']."<br>";
	//						echo $adminUsers->statut ; exit();	
				
				if($users->updateUser()) {
					$notices->create_notice('success', 'User modifié');
					header('location:index.php?module=users&action=form&id='.$_GET['id']);exit();
				}
				else {
					$notices->create_notice('danger', 'erreur modif');
					header('location:index.php?module=users&action=form&id='.$_GET['id']);exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$users->user_id = $_GET['id'];
					$item = $users->getOne();
					if(empty($item)) {
						$notices->create_notice('danger', 'Unknown user !');
						header('location:index.php?module=users');exit();
					}

				$statuts = $users->getStatuts();

				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
				$styles_to_load = array("style");
				
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
				$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
				$styles_to_load = array("style");
				
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
					$ajax_item = $users->getOneArray();
					$ajax_item = json_encode($ajax_item);
					echo $ajax_item;
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_delete_avatar') {
					if(unlink(_ADMIN_PATH . 'img/photo_' . $_POST['id'] . '.jpg')) {
						echo true;
					}
					else {
						echo false;
					}
			}
		}
	}
?>