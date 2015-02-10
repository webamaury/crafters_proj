<?php

/**
 * Class DeliveryController
 */
class DeliveryController extends CoreControlers
{

	/**
	 * @param $arrayTools
	 * @param $notices
	 */
	function __construct($arrayTools, $notices)
	{

		if (!isset($_GET['action']) && !isset($_POST['action'])) {
			$method = 'main';
		} else if (isset($_POST['action'])) {
			$method = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$method = $_GET['action'];
		}

		$this->$method($arrayTools, $notices);
	}

	/**
	 * @param $arrayTools
	 * @param $notices
	 */
	function main($arrayTools, $notices)
	{
		/*************************************************************
		 * 	TRAITEMENT PHP											**
		 * **********************************************************/

		//var_dump($_SESSION[_SES_NAME]);

		/*************************************************************
		 * 	APPEL TOOLS												**
		 * **********************************************************/
		$toolsToLoad = array('bootstrap-css', 'font-awesome');

		/*************************************************************
		 * 	VARIABLES LAYOUT										**
		 * **********************************************************/
		DEFINE("_METATITLE", "Delivery");
		DEFINE("_METADESCRIPTION", "Delivery");

		/*************************************************************
		 * 	VUE														**
		 * **********************************************************/
		include_once('../app/views/delivery/display.php');
	}

}

?>