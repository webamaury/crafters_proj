<?php
	
	class ordersController extends CoreControlers {
		
		function __construct($arrayTools, $notices, $modules) {
			//include_once(_APP_PATH . 'models/lib.admin_users.php');
			include_once _APP_PATH . 'models/class.orders.php';
			$orders = new ClassOrders();
			
			if(isset($_GET['action']) && $_GET['action'] == "delete") {
				$orders->order_id = $_GET['id'];
				if($orders->deleteOrder()) {
					$notices->createNotice('success', 'Orders deleted');
					header('location:index.php?module=orders');exit();
				}
				else {
					$notices->createNotice('danger', 'Impossible to delete !');
					header('location:index.php?module=orders');exit();
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
					header('location:index.php?module=orders');exit();
				}
				else {
					$notices->createNotice('danger', 'Error while sending the message !');
					header('location:index.php?module=orders');exit();
				}
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'modifier') {

				$orders->order_id 			= $_GET['id'];				
				$orders->user_mail 			= $_POST['mail'];
				$orders->user_firstname 		= $_POST['firstname'];
				$orders->user_name 			= $_POST['name'];
				$orders->user_phone 			= $_POST['phone'];
				$orders->user_birthday		= $_POST['birthday'];
				$orders->user_status 		= $_POST['statut'];
				

				if($orders->updateUser()) {
					$notices->createNotice('success', 'User modifié');
					header('location:index.php?module=users&action=form&id='.$_GET['id']);exit();
				}
				else {
					$notices->createNotice('danger', 'erreur modif');
					header('location:index.php?module=users&action=form&id='.$_GET['id']);exit();
				}
			}
			else if(isset($_GET['action']) && $_GET['action'] == 'form') {
					$orders->order_id = $_GET['id'];
					$item = $orders->getOne();
					if(empty($item)) {
						$notices->createNotice('danger', 'Unknown user !');
						header('location:index.php?module=users');exit();
					}

				$statuts = $orders->getStatuts();

				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script");
				$stylesToLoad = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Orders");
				DEFINE("_METADESCRIPTION", "Orders");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_orders/form.php');
			}
			else if((!isset($_GET['action']) && !isset($_POST['action'])) || (isset($_GET['action']) && $_GET['action'] == 'list')) {
				$items = $orders->getList();
				
				//$items = $adminUsers;
				##############################################################
				##	APPEL TOOLS												##
				##############################################################
				$toolsToLoad = array("bootstrap-css", "jquery", "bootstrap-js", "admin-script", "datatable-css", "datatable-js");
				$stylesToLoad = array("style");
				
				##############################################################
				##	VARIABLES LAYOUT										##
				##############################################################
				DEFINE("_METATITLE", "Orders");
				DEFINE("_METADESCRIPTION", "Orders");
				
				##############################################################
				##	VUE														##
				##############################################################
				include_once( _APP_PATH . 'views/admin_orders/display.php');
			}
			else if(isset($_POST['action']) && $_POST['action'] == 'ajax_display_order_fiche') {
					$orders->order_id = $_POST['id'];
					$ajaxItem = $orders->getOneArray();
					$ajaxItem['address'] = $orders->getOneArrayAddress();
					$ajaxItem['product'] = $orders->getOneArrayProduct();
					$ajaxItem = json_encode($ajaxItem);
					echo $ajaxItem;
			}
			else if ($_GET['action'] == "send" ) {
				$orders->order_hash = $_GET['order'];
				$orderInfos = $orders->getOrderWithHash();
				$user = $orders->getUserOfOrder();

				$orders->statutSend();

				$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.send.htm');
				// On remplace les infos personnelles
				if ($orderInfos->order_delivery == 0) {
					$tpl = str_replace("%DELIVERY%", '10 days with a maximum of 28 days', $tpl);
				} else {
					$tpl = str_replace("%DELIVERY%", '3 days with a maximum of 10 days', $tpl);
				}
				$tpl = str_replace("%ORDER_HASH%", $_GET['order'], $tpl);

				$return = $this->send_mail($tpl,
					"Crafters",
					'amaury.gilbon@gmail.com',
					$user->user_mail,
					'Order [' . $_GET['order'] . '] confirmation');

				$notices->createNotice('success', 'Status changed to sent');
				header ('location:index.php?module=orders');
			}
			else if ($_GET['action'] == "paid" ) {
				$orders->order_hash = $_GET['order'];
				$orderInfos = $orders->getOrderWithHash();
				$orders->statutPaid();
				$orders->order_id = $orderInfos->order_id;
				$address = $orders->getOneArrayAddress();
				$user = $orders->getUserOfOrder();


				$tpl = file_get_contents(_APP_PATH . 'mail_templates/mails.payment.htm');
				// On remplace les infos personnelles
				$tpl = str_replace("%PAY_MODE%", 'Check', $tpl);
				$tpl = str_replace("%ORDER_HASH%", $_GET['order'], $tpl);

				$infosclient = array(
					"name" => $user->user_firstname . " " . $user->user_name ,
					"adr1" => $address[0]['address_numberstreet'],
					"adr2" => $address[0]['address_zipcode'] . " " . $address[0]['address_town']
				);
				$infospanier = unserialize($orderInfos->order_custom);
				/*foreach ($infospanier as $key => $infospanierOne) {
					$infospanier[$key] = (array) $infospanierOne;
					unset($infospanierOne);


				}*/

				$infoscommande = $orderInfos;


				$return = $this->generateFacture($infosclient, $infospanier, $infoscommande);


				$this->send_mail($tpl,
					"Crafters",
					'amaury.gilbon@gmail.com',
					$user->user_mail,
					'Order [' . $orders->order_hash . '] confirmation',
					"",
					$orders->order_hash);

				$notices->createNotice('success', 'Status changed to paid');
				header ('location:index.php?module=orders');
			}
		}
	}
?>