<?php
	
	class usersController {
		
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
				$users->user_phone 			= $_POST['phone'];
				$users->user_birthday		= $_POST['birthday'];
				$users->user_status 		= $_POST['statut'];
				
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