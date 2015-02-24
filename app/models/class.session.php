<?php

/**
 * Class Session
 */
class Session {
	/**
	 *
	 */
	function __construct() {
		session_name(_SES_NAME);
		session_start();
	}

	function unsetVariable($var) {
		unset($var);
	}
}

?>