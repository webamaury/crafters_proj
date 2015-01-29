<?php
class CoreControlers {
	
	function get_extension($filename) {
		return strtolower(substr($filename, strrpos($filename, ".") + 1, strlen($filename)));
	}
	
	function load_css($stylesToLoad) {
		$html_style = '';
		foreach ($stylesToLoad as $style_to_load) {
			$html_style .= '
		<link href="css/'.$style_to_load.'.css" rel="stylesheet" type="text/css" media="screen" id="css" />';
		}
		return $html_style ;
	}
	
	function load_tools($toolsToLoad, $arrayTools) {
		//var_dump($arrayTools);
		$html_tools = '';
		foreach ($toolsToLoad as $tool_to_load) {
			$html_tools .= '
		'.$arrayTools[$tool_to_load];
		}
		return $html_tools;
	}
	#####  This function will proportionally resize image ##### 
	function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){
		
		if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
		
		//do not resize if image is smaller than max size
		if($image_width <= $max_size && $image_height <= $max_size){
			if($this->save_image($source, $destination, $image_type, $quality)){
				return true;
			}
		}
		
		//Construct a proportional size of new image
		$image_scale	= min($max_size/$image_width, $max_size/$image_height);
		$new_width		= ceil($image_scale * $image_width);
		$new_height		= ceil($image_scale * $image_height);
		
		$new_canvas		= imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image
		
		//Copy and resize part of an image with resampling
		if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
			$this->save_image($new_canvas, $destination, $image_type, $quality); //save resized image
		}
	
		return true;
	}
	
	##### This function corps image to create exact square, no matter what its original size! ######
	function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
		if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
		
		if( $image_width > $image_height )
		{
			$y_offset = 0;
			$x_offset = ($image_width - $image_height) / 2;
			$s_size 	= $image_width - ($x_offset * 2);
		}else{
			$x_offset = 0;
			$y_offset = ($image_height - $image_width) / 2;
			$s_size = $image_height - ($y_offset * 2);
		}
		$new_canvas	= imagecreatetruecolor( $square_size, $square_size); //Create a new true color image
		
		//Copy and resize part of an image with resampling
		if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
			$this->save_image($new_canvas, $destination, $image_type, $quality);
		}
	
		return true;
	}
	
	##### Saves image resource to file ##### 
	function save_image($source, $destination, $image_type, $quality){
		switch(strtolower($image_type)){//determine mime type
			case 'image/png': 
				imagepng($source, $destination); return true; //save png file
				break;
			case 'image/gif': 
				imagegif($source, $destination); return true; //save gif file
				break;          
			case 'image/jpeg': case 'image/pjpeg': 
				imagejpeg($source, $destination, $quality); return true; //save jpeg file
				break;
			default: return false;
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
		$message = '';

		//------------------------------------------------------
		//FRONTIERE
		//------------------------------------------------------
		$frontiere=md5(uniqid(mt_rand()));


		//------------------------------------------------------
		//HEADERS DU MAIL
		//------------------------------------------------------
		$headers = 'From: "'.$name_expe.'" <'.$email_expediteur.'>'."\n";
		$headers .= 'Return-Path: <'.$reply.'>'."\n";
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

}
?>