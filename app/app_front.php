<?php
	
//Constitution de l'URL
$url = _APP_PATH . 'controllers/' . $module . '/' . $module . '.php';
//Dispatching vers controleur / action ou bien redirection 404
if (file_exists($url)) {
	include_once($url);
	new $class($arrayCss, $arrayJs, $notices);
} else {
	include_once('../app/controllers/autres/autres.php');
	new AutreController($arrayCss, $arrayJs, $notices);
}

?>