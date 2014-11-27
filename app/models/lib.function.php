<?php

function load_css($styles_to_load) {
	$html_style = '';
	foreach ($styles_to_load as $style_to_load) {
		$html_style .= '
	<link href="css/'.$style_to_load.'.css" rel="stylesheet" type="text/css" media="screen" id="css" />';
	}
	return $html_style ;
}

function load_tools($tools_to_load, $array_tools) {
	//var_dump($array_tools);
	$html_tools = '';
	foreach ($tools_to_load as $tool_to_load) {
		$html_tools .= '
	'.$array_tools[$tool_to_load];
	}
	return $html_tools;
}

function load_modules() {
	$modules = array();

	$modules_to_exclude = array('index', 'login', 'traces');

	$path_to_modules = _APP_PATH . 'controlers';
	if ($handle = opendir( $path_to_modules ))
	{
	    while (($item = readdir($handle)) !== false )
	    {
	        if (is_dir($path_to_modules . '/' . $item) && $item != '.' && $item != '..' && !in_array($item, $modules_to_exclude) && substr($item, 0, 6) == "admin_")
	        {
				if (file_exists($path_to_modules . '/' . $item . '/config.php'))
				{
					require_once($path_to_modules . '/' . $item . '/config.php');
					$modules[$item] = $module_details;
				}
			}
	    }
	}
	$modules = array_sort_by_column($modules, 'position');
	unset($module_details);

	return $modules;
}

function array_sort_by_column($array, $column) {
	if(!empty($array)) {
	
		foreach($array as $key => $row) {
			if(isset($row[$column])) {
				$sort_values[$key] = $row[$column];
			}
		}
		asort($sort_values);
		reset($sort_values);
		
		while (list ($arr_key, $arr_val) = each ($sort_values)) {
			$sorted_arr[] = $array[$arr_key];
		}
		unset($array);
		return $sorted_arr;

	}
	
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


function send_mail($tpl, $fromfirstname, $fromname, $frommail, $tomail, $subject) {
	
	// On remplace les infos de la signature
	$from = stripslashes($fromfirstname . ' ' . $fromname);
	$from_mail = $frommail;
	
	// Envoi du mail
	$to = $tomail;
	$from = '"' . $from . '"' . ' <'.$from_mail.'>';
	$subject = $subject;
	$content = $tpl;
	
	$headers = 'From: '. $from . "\n";
	$headers .= 'Reply-to: '. $from . "\n";
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Return-Path: <'.$from_mail.'>' . "\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\n";
	$headers .= 'X-Sender: <monsite.com>' ." \n";
	$headers .= 'X-Mailer: PHP/'.phpversion() . "\n";
	
	if(mail($to, $subject, $content, $headers)) {
		return true;
	}
}




















?>