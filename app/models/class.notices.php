<?php
	
	class classNotices {
		
		function __construct() {
			
		}
		function create_notice($type, $content) {
			$_SESSION['notices'] = array('type' => $type, 'content' => $content);
		}
		
		function clear_notice() {
			unset($_SESSION['notices']);
		}
		
		function display_notice() {
			if(isset($_SESSION['notices'])) {
				$return = '<div class="col-xs-12"><div class="alert alert-'.$_SESSION['notices']['type'].' alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					'.$_SESSION['notices']['content'].'
				</div></div>';
		
				return $return ;
			}
		}

		
	}
	
?>