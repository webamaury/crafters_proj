<?php

/**
 * Class adminUsersController
 */
class AdminUsersController {

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
		} else if (isset($_POST['action']) && $_POST['action'] === "send_mail") {

			$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.header.htm');
			$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.contact.htm');
			$tpl .= file_get_contents(_APP_PATH . 'mail_templates/mails.footer.htm');

			// On remplace les infos personnelles
			$tpl = str_replace("%CONTENT%", stripslashes($_POST['content']), $tpl);
			$tpl = str_replace("%SITE_NAME%", _SITE_NAME, $tpl);


			if (send_mail($tpl,
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
			if ((isset($_GET['id']) && $_GET['id'] === $_SESSION['ADMIN-USER']['id']) || (isset($_GET['id']) && $_SESSION['ADMIN-USER']['statut'] === 1)) {
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
			$ajaxItem = json_encode($ajaxItem);
			echo $ajaxItem;
		} else if (isset($_POST['action']) && $_POST['action'] === 'ajax_delete_avatar') {
			if (unlink(_ADMIN_PATH . 'img/photo_' . $_POST['id'] . '.jpg')) {
				echo true;
			} else {
				echo false;
			}
		} else if (isset($_POST['action']) && $_POST['action'] === 'ajax_update_password') {
			if ($_SESSION['ADMIN-USER']['id'] === $_POST['admin°id']) {
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
		} else {

		}


	}
}

?>