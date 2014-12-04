<?php
	
	class messagesController {
		
		function __construct($array_tools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.admin_messages.php';
			$messages = new classMessages();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$messages->message_id = $_GET['message_id'];
				if($messages->delete_admin()) {
					$notices->create_notice('success', 'Admin deleted');
					header('location:index.php?module=messages');exit();
				}
				else {
					$notices->create_notice('danger', 'Impossible to delete !');
					header('location:index.php?module=messages');exit();
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
					header('location:index.php?module=messages');exit();
				}
				else {
					$notices->create_notice('danger', 'Error while sending the message !');
					header('location:index.php?module=messages');exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$messages->message_id = $_GET['id'];
					$item = $messages->get_one();
					//var_dump($item); exit();
					if(empty($item)) {
						$notices->create_notice('danger', 'Unknown message !');
						header('location:index.php?module=messages');exit();
					}
					$statuts = $messages->get_statuts();

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
				include_once('../app/views/admin_messages/form.php');
			}
			else if((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] == 'list')) {
				$items = $messages->get_list();
				
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
				include_once('../app/views/admin_messages/display.php');
			}
			else {
				
			}



		}
	}
?>