<?php
	
	class Session {
		function __construct() {
			
			session_name(_SES_NAME);
			session_start();

		}
		
	}
	
	
?>