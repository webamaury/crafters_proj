<?php
class CoreControlers {
	function get_extension($filename) {
		return strtolower(substr($filename, strrpos($filename, ".") + 1, strlen($filename)));
	}
}
?>