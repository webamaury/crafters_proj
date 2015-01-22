<?php
	
//Constitution de l'URL
$url = _APP_PATH . 'controllers/' . $module . '/' . $module . '.php';
//Dispatching vers controleur / action ou bien redirection 404
if (file_exists($url)) {
	include_once($url);
	new $class($array_tools, $notices, $modules);
} else {
	include_once('../app/controllers/admin_autres/404.php');
}

?>