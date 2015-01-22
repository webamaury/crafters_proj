<?php
	
//Constitution de l'URL
$url = _APP_PATH . 'controllers/' . $module . '/' . $module . '.php';
//Dispatching vers controleur / action ou bien redirection 404
if (file_exists($url)) {
	include_once($url);
	new $class($arrayTools, $notices);
} else {
	include_once('../app/controllers/autres/404.php');
	new AutreController($arrayTools, $notices);
}

?>