<?php
	class indexController {
	
		function __construct($arrayTools, $notices, $modules) {
			
		##############################################################
		##	TRAITEMENT PHP											##
		##############################################################
		include(_APP_PATH . 'ext_lib/gapi/identifiants.php');
		include(_APP_PATH . 'ext_lib/gapi/gapi.class.php');
		//Fonction de connexion a Google Analytics
		$ga = new gapi(ga_email,ga_password);

		//On filtre les navigateurs ou on veut recuperer les donnees
		$filter = 'browser == Chrome || browser == Firefox || browser == Internet Explorer || browser == Safari || browser == Opera';
		//On fait notre requete sur l'API Google Analytics
		$ga->requestReportData(ga_profile_id,array('nthDay', 'day'),array('visits'), 'nthDay',$filter, date('Y-m-d',strtotime('15 day ago')), date('Y-m-d',time()));
		$results = $ga->getResults();
		//var_dump($results);


		/*
		* Exemple avec les continents
		* On recupere le nombre de page vues (pageviews) pour chaque continent,
		* puis on les additionnes pour ensuite faire le pourcentage de chaque continent et
		* stocker le resultat dans un tableau puis le mettre en format JSON pour le JavaScript.
		*/

		//On filtre les continents ou on veut recuperer les donnees
		$filter_c = 'browser == Chrome || browser == Firefox || browser == Internet Explorer || browser == Safari || browser == Opera';

		$ga->requestReportData(ga_profile_id,array('browser'),array('visitors'),NULL,$filter_c,'2012-11-30',(date('Y-m-d',time())));

		//On compte le nombre totale de pages vues pour tout les continents
		$total_browsers = 0;
		$resultsBrowsers = $ga->getResults();
		foreach($resultsBrowsers as $browser)
		{
			$total_browsers += $browser->getVisitors();
		}
		$dataset_browsers = array();

		//On ecris le resultat pour chaque contient dans un tableau
		foreach($resultsBrowsers as $browser)
		{
			/*On fait le pourcentage par rapport au nombre de vues totales
			et au nombre de vues pour chaque navigateur*/
			$pourcent = ($browser->getVisitors()*100)/$total_browsers;

			//On met les valeurs dans le tableau
			$dataset_browsers["$browser"] = round($pourcent);

		}
		//var_dump($dataset_browsers);
		//On met les donnees en format Json et on les stocks dans une variable
		$continent_donnee = '[
		{ label: "Opera", data: '.$dataset_browsers['Opera'].', color: "#f26645"},
		{ label: "Internet Explorer", data: '.$dataset_browsers['Internet Explorer'].', color: "#fecd64"},
		{ label: "Firefox", data: '.$dataset_browsers['Firefox'].', color: "#40befb" },
		{ label: "Chrome", data: '.$dataset_browsers['Chrome'].', color: "#99cc65" },
		{ label: "Safari", data: '.$dataset_browsers['Safari'].', color: "#ab65cc" }
		]';

		include_once(_APP_PATH . 'models/class.product.php'); $ClassProduct = new ClassProducts();
		$new_prod = $ClassProduct->getNewProduct();

		include_once(_APP_PATH . 'models/class.users.php'); $ClassUser = new ClassUsers();
		$new_user = $ClassUser->getNewUser();

		include_once(_APP_PATH . 'models/class.orders.php'); $ClassOrder = new ClassOrders();
		$new_order = $ClassOrder->getNewOrder();

		include_once(_APP_PATH . 'models/class.messages.php'); $ClassMessage = new ClassMessages();
		$new_message = $ClassMessage->getNewMessage();
//var_dump($new_prod, $new_user, $new_order, $new_message);
		##############################################################
		##	APPEL TOOLS												##
		##############################################################
		$toolsToLoad = array("bootstrap-css", "jquery" , "bootstrap-js");
		$stylesToLoad = array("style");
		
		##############################################################
		##	VARIABLES LAYOUT										##
		##############################################################
		DEFINE("_METATITLE", "Accueil Admin");
		DEFINE("_METADESCRIPTION", "Accueil Admin");
		
		##############################################################
		##	VUE														##
		##############################################################
		include_once( _APP_PATH . 'views/admin_index/display.php');
				
		}
		
	}
?>