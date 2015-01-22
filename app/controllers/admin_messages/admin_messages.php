<?php

/**
 * Class messagesController
 */
class MessagesController {

	/**
	 * @param $array_tools
	 * @param $notices
	 * @param $modules
	 */
	function __construct($array_tools, $notices, $modules) {
		//include_once(_APP_PATH . 'models/lib.admin_users.php');
		include_once _APP_PATH . 'models/class.messages.php';
		$messages = new ClassMessages();

		if (isset($_GET['action']) && $_GET['action'] === "delete") {
			$messages->message_id = $_GET['id'];
			if ($messages->delete_message()) {
				$notices->createNotice('success', 'Message deleted');
				header('location:index.php?module=messages');
				exit();
			} else {
				$notices->createNotice('danger', 'Impossible to delete !');
				header('location:index.php?module=messages');
				exit();
			}
		} else if (isset($_GET['action']) && $_GET['action'] === 'form') {
			$messages->message_id = $_GET['id'];
			$item = $messages->getOne();
			//var_dump($item); exit();
			if (empty($item)) {
				$notices->createNotice('danger', 'Unknown message !');
				header('location:index.php?module=messages');
				exit();
			}
			$statuts = $messages->get_statuts();

			/*************************************
			 *	APPEL TOOLS                     **
			 *************************************/
			$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
			$styles_to_load = array("style");

			/*************************************
			 *	VARIABLES LAYOUT                **
			 *************************************/
			DEFINE("_METATITLE", "Admin message");
			DEFINE("_METADESCRIPTION", "Admin message");

			/*************************************
			 *	VUE                             **
			 *************************************/
			include_once(_APP_PATH . 'views/admin_messages/form.php');
		} else if ((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] === 'list')) {
			$items = $messages->get_list();

			//$items = $adminUsers;
			/*************************************
			 *	APPEL TOOLS                     **
			 *************************************/
			$tools_to_load = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
			$styles_to_load = array("style");

			/*************************************
			 *	VARIABLES LAYOUT                **
			 *************************************/
			DEFINE("_METATITLE", "Admin message");
			DEFINE("_METADESCRIPTION", "Admin message");

			/*************************************
			 *	VUE                             **
			 *************************************/
			include_once(_APP_PATH . 'views/admin_messages/display.php');
		} else if (isset($_POST['action']) && $_POST['action'] === 'ajax_display_message_fiche') {
			$messages->message_id = $_POST['id'];
			$ajax_item = $messages->get_one_array();
			$ajax_item = json_encode($ajax_item);
			echo $ajax_item;
		}


	}
}

?>