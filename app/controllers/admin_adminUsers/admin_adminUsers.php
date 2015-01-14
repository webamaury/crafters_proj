<?php
	
	class adminUsersController {
		
		function __construct($array_tools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.adminUsers.php';
			$adminUsers = new classAdminUsers();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$adminUsers->id = $_GET['id'];
				if($adminUsers->delete_admin()) {
					$notices->create_notice('success', 'Admin deleted');
					header('location:index.php?module=adminUsers');exit();
				}
				else {
					$notices->create_notice('danger', 'Impossible to delete !');
					header('location:index.php?module=adminUsers');exit();
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
					header('location:index.php?module=adminUsers');exit();
				}
				else {
					$notices->create_notice('danger', 'Error while sending the message !');
					header('location:index.php?module=adminUsers');exit();
				}
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'modifier') {

				$adminUsers->id 			= $_GET['id'];				
				$adminUsers->mail 			= $_POST['mail'];
				$adminUsers->firstname 		= $_POST['firstname'];
				$adminUsers->name 			= $_POST['name'];
				$adminUsers->phone 			= $_POST['phone'];
				if(isset($_POST['statut'])){ $adminUsers->statut = $_POST['statut'];}else{$adminUsers->statut = 1;}
				
	//						echo $_POST['statut']."<br>";
	//						echo $adminUsers->statut ; exit();	
				
				if($adminUsers->update_admin()) {
					$notices->create_notice('success', 'User modifié');
					header('location:index.php?module=adminUsers&action=form&id='.$_GET['id']);exit();
				}
				else {
					$notices->create_notice('danger', 'erreur modif');
					header('location:index.php?module=adminUsers&action=form&id='.$_GET['id']);exit();
				}
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajouter') {

				$adminUsers->mail 			= $_POST['mail'];
				$adminUsers->password 		= md5($_POST['password']);
				$adminUsers->firstname 		= $_POST['firstname'];
				$adminUsers->name 			= $_POST['name'];
				$adminUsers->phone 			= $_POST['phone'];
				$adminUsers->statut			= $_POST['statut'];				
				
				if($adminUsers->create_admin()) {
					$notices->create_notice('success', 'Admin added');
					header('location:index.php?module=adminUsers');exit();
				}
         		else {
                	$notices->create_notice("danger", "error while adding new admin");
                	header("location:index.php?module=adminUsers");
                }
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
				if((isset($_GET['id']) && $_GET['id'] == $_SESSION['ADMIN-USER']['id']) || (isset($_GET['id']) && $_SESSION['ADMIN-USER']['statut'] == 1)) {
					$adminUsers->id = $_GET['id'];
					$item = $adminUsers->get_one();
					if(empty($item)) {
						$notices->create_notice('danger', 'Unknown user !');
						header('location:index.php?module=adminUsers');exit();
					}
					else if ($_SESSION['ADMIN-USER']['statut'] == $item->statut && $_SESSION['ADMIN-USER']['id'] != $item->id) {
						$notices->create_notice('danger', 'Impossible action bis !');
						header('location:index.php?module=adminUsers');exit();					
					}
				}
				else if (isset($_GET['id'])) {
						$notices->create_notice('danger', 'Impossible action !');
						header('location:index.php?module=adminUsers');exit();					
				}
				$statuts = $adminUsers->get_statuts();

				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
				$styles_to_load = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Admin user");
				DEFINE("_METADESCRIPTION", "Admin user");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_admin_users/form.php');
			}
			else if((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] == 'list')) {
				$items = $adminUsers->get_list();
				
				//$items = $adminUsers;
				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
				$styles_to_load = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Admin users");
				DEFINE("_METADESCRIPTION", "Admin users");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_admin_users/display.php');
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_display_admin_fiche') {
					$adminUsers->id = $_POST['id'];
					$ajax_item = $adminUsers->get_one_array();
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
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_update_password') {
					if($_SESSION['ADMIN-USER']['id'] == $_POST['admin°id']){
						if($_POST['new_password'] == $_POST['confirm_password']) {
							if($_SESSION['ADMIN-USER']['password'] == md5($_POST['current_password'])) {
								$adminUsers->id = $_POST['admin_id'];
								$adminUsers->password = md5($_POST['new_password']);
								$myreturn = $adminUsers->update_password();
								if($myreturn) {
									$_SESSION['ADMIN-USER']['password'] = md5($_POST['new_password']);
									echo true;
								}
								else {
									echo "error_sql";
								}
							}
							else {
								echo "wrong_current";
							}
						}
						else {
							echo "wrong_confirm";
						}
					}
					else {
						echo "modif_impo";
					}
			}
			else {
				
			}



		}
	}
?>