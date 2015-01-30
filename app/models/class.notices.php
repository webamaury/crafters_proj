<?php
/**
 * Class ClassNotices
 */
class ClassNotices {

	/**
	 *
     */
	function __construct() {
			
	}

	/**
	 * Permet de créer un message
	 * @param $type
	 * @param $content
     */
	function createNotice($type, $content) {
		$_SESSION[_SES_NAME]['notices'] = array('type' => $type, 'content' => $content);
	}

	/**
	 * Permet de nettoyer la session pour supprimer les messages
     */
	function clearNotice() {
		unset($_SESSION[_SES_NAME]['notices']);
	}

	/**
	 * Permet d'afficher un message
	 * @return string
     */
	function displayNotice() {
		if (isset($_SESSION[_SES_NAME]['notices'])) {
			$return = '<div class="col-xs-12">';
			$return .= '<div class="alert alert-' . $_SESSION[_SES_NAME]['notices']['type'] . ' alert-dismissible" role="alert">';
			$return .= '<button type="button" class="close" data-dismiss="alert">';
			$return .= '<span aria-hidden="true">&times;</span>';
			$return .= '<span class="sr-only">Close</span>';
			$return .= '</button>' . $_SESSION[_SES_NAME]['notices']['content'] . '</div></div>';

			return $return;
		}
	}

		
}
	
?>