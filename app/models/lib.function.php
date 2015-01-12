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

	$path_to_modules = _APP_PATH . 'controllers';
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


function send_mail($text, $name_expe, $email_expe, $email_desti, $subject, $reply = null, $file = null)
{
	
	
	
	//------------------------------------------------------
	//VARIABLES
	//------------------------------------------------------
	$email_expediteur=$email_expe;
	//$email_reply=$email_expe;
	//$message_text='Bonjour'."\n\n".'Voici un message au format texte';
	
	$destinataire=$email_desti;
	$sujet=$subject;
	
	$message_html=$text;
	
	
	//------------------------------------------------------
	//FRONTIERE
	//------------------------------------------------------
	$frontiere=md5(uniqid(mt_rand()));
	
	
	//------------------------------------------------------
	//HEADERS DU MAIL
	//------------------------------------------------------
	$headers = 'From: "'.$name_expe.'" <'.$email_expediteur.'>'."\n";
	$headers .= 'Return-Path: <'.$email_reply.'>'."\n";
	$headers .= 'MIME-Version: 1.0'."\n"; 
	$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
	/*
	//------------------------------------------------------
	//MESSAGE TEXTE
	//------------------------------------------------------
	$message = 'This is a multi-part message in MIME format.'."\n\n";
	
	$message .='--'.$frontiere."\n";
	$message .= 'Content-Type: text/plain; charset="iso-8859-1"'."\n";
	$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
	$message .= $message_text."\n\n";
	*/
	//------------------------------------------------------
	//MESSAGE HTML
	//------------------------------------------------------
	$message .='--'.$frontiere."\n";
	
	$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
	$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
	$message .= $message_html."\n\n";
	/*
	//------------------------------------------------------
	//PIECE JOINTE
	//------------------------------------------------------
	$message .='--'.$frontiere."\n";
	
	$message .= 'Content-Type: image/jpeg; name="image.jpg"'."\n";
	$message .= 'Content-Transfer-Encoding: base64'."\n";
	$message .= 'Content-Disposition:attachement; filename="image.jpg"'."\n\n";
	 
	$message .= chunk_split(base64_encode(file_get_contents('image.jpg')))."\n";
	*/
	//------------------------------------------------------
	//ENVOI DU MAIL
	//------------------------------------------------------
	if(mail($destinataire, $sujet, $message, $headers))
	{
		return true;
	}
	else
	{
		return false;
	}
}
/*
function upload_image($_POST) {
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	$max_file_size = 100000 * 1024; #200kb
	$nwLR = $nhLR = 200; # image with # height LR
	//$nwHR = $nhHR = 600; # image with # height HR
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ( isset($_FILES['image']) ) {
			if (! $_FILES['image']['error'] && $_FILES['image']['size'] < $max_file_size) {
				$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
				$file = md5(uniqid(rand(), true));
	
				if (in_array($ext, $valid_exts)) {
						$pathLR = '../photos/LR/' . $file . '.' . $ext;
						//$pathHR = '../photos/HR/' . $file . '.' . $ext;
						$size = getimagesize($_FILES['image']['tmp_name']);
	
						$x = (int) $_POST['x'];
						$y = (int) $_POST['y'];
						$w = (int) $_POST['w'] ? $_POST['w'] : $size[0];
						$h = (int) $_POST['h'] ? $_POST['h'] : $size[1];
	
						$data = file_get_contents($_FILES['image']['tmp_name']);
						$vImg = imagecreatefromstring($data);
						$dstImgLR = imagecreatetruecolor($nwLR, $nhLR);
						//$dstImgHR = imagecreatetruecolor($nwHR, $nhHR);
						imagecopyresampled($dstImgLR, $vImg, 0, 0, $x, $y, $nwLR, $nhLR, $w, $h);
						//imagecopyresampled($dstImgHR, $vImg, 0, 0, $x, $y, $nwHR, $nhHR, $w, $h);
						imagejpeg($dstImgLR, $pathLR);
						//imagejpeg($dstImgHR, $pathHR);
						imagedestroy($dstImgLR);
						//imagedestroy($dstImgHR);
	
						//echo "<img src='$pathLR' /><br/>";
						//echo "<img src='$pathHR' />";
			
						
						/*
						insert_post($file, $ext);
						
						$postid = recup_postid($file, $ext);
	
						if($_POST["descr"]!='')
						{
						insert_descr($postid->POS_ID, $_POST["descr"]);	
						}				
						*//*
						header("location:");
	
						
					} else {
						echo 'unknown problem!';
					} 
			} else {
				echo 'file is too small or large';
			}
		} else {
			echo 'file not set';
		}
	} else {
		echo 'bad request!';
	}

}
*/
















?>