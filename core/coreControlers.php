<?php
class CoreControlers {

	function get_extension($filename) {
		return strtolower(substr($filename, strrpos($filename, ".") + 1, strlen($filename)));
	}

	function load_css($CssToLoad, $arrayCss) {
		$html_css = '';
		foreach ($CssToLoad as $css) {
			$html_css .= '
		'.$arrayCss[$css];
		}
		return $html_css;
	}
	
	function load_js($JsToLoad, $arrayJs) {
		$html_tools = '';
		foreach ($JsToLoad as $js) {
			$html_tools .= '
		'.$arrayJs[$js];
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

		//------------------------------------------------------
		//PIECE JOINTE
		//------------------------------------------------------
		if ($file != null) {
			$message .='--'.$frontiere."\n";

			$message .= 'Content-Type: application/pdf; name="facture_' . $file . '.pdf"'."\n";
			$message .= 'Content-Transfer-Encoding: base64'."\n";
			$message .= 'Content-Disposition:attachement; filename="facture_' . $file . '.pdf"'."\n\n";

			$message .= chunk_split(base64_encode(file_get_contents(_PATH_FOLDER . 'uploads/factures/facture_' . $file . '.pdf')))."\n";
		}

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
	function loadView($view, $arrayTools, $notices) {
		include_once($view);
	}

	/**
	 * COOKIES
	 */
	function cookieRemenberMe($values)
	{
		setcookie(_COOKIE_NAME, $values, time()+3600*24*365);
	}
	function removeCookie() {
		setcookie(_COOKIE_NAME, "", time()+1);
	}
	function generateFacture($infosclient, $infospanier, $infoscommande)
	{
		ob_start();
		?>
		<style type="text/css">
			* { color: #717375; }
			hr { background: #717375; height: 1px; border: none; }
			table { border-collapse: collapse; width: 100%; color: #717375; font-size: 11pt; font-family: helvetica; line-height: 6mm; }
			strong { color: #000; }
			em { font-size: 9pt; }
			h3 { color: #000; margin: 0; padding: 0; }
			td.right { text-align: right; }
				table.border td { border: 1px solid #CFD1D2; padding: 3mm 1mm; }
			table.border th, td.black { background: #333333; color: #FFF; font-weight: normal; padding: 1mm; }
			td.noborder { border:none; }
			tr.smallpad td { padding: 1mm; }
		</style>

		<page backtop="20mm" backleft="10mm" backright="10mm" bachbottom="30mm">
		<page_footer style="text-align: center;">
			<hr/>
			Crafters &copy; All right reserved <?php echo date('Y'); ?>
		</page_footer>
			<table style="vertical-align: top;">
				<tr>
					<td style="width: 72%;">
						<br/><br/><br/>
						<strong><?php echo $infosclient["name"]; ?></strong><br/>
						<?php echo $infosclient["adr1"]; ?><br/>
						<?php echo $infosclient["adr2"]; ?>
					</td>
					<td style="width: 28%">
						<img style="margin-left: -3mm;" src="<?php echo _PATH_FOLDER; ?>img/logo.png" alt="logo"/><br/>
						<strong>Crafters</strong><br/>
						28 Place de la Bourse<br/>
						75002 Paris<br/>
						crafters.fr<br/>
						01 45 86 43 52
					</td>
				</tr>
			</table>
			<br/><br/><br/><br/><br/>
			<table>
				<tr>
					<td style="width:50%;"><h3>Invoice Order [<?php echo $infoscommande->order_hash; ?>]</h3></td>
					<td style="width:50%;" class="right">Date :<?php echo date('d/m/Y'); ?></td>
				</tr>
			</table>
			<br/><br/><br/>
			<table class="border">
				<thead>
				<tr>
					<th style="width: 56%">Description</th>
					<th style="width: 12%">Type</th>
					<th style="width: 6%">Size</th>
					<th style="width: 6%">Qtt</th>
					<th style="width: 10%">Unit</th>
					<th style="width: 10%">Price</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($infospanier as $product) :
					if ($product['size'] == 's') {
						$unitprice = 5;
					} else if ($product['size'] == 'm') {
						$unitprice = 10;
					} else if ($product['size'] == 'l') {
						$unitprice = 15;
					}
					$price = $unitprice * $product['quantity'];
					if ($infoscommande->order_delivery == 0) {
						$deliveryPrice = 6;
					} else {
						$deliveryPrice = 10;
					}
				?>
				<tr>
					<td><?php echo $product['name']; ?></td>
					<td><?php echo $product['type']; ?></td>
					<td><?php echo $product['size']; ?></td>
					<td><?php echo $product['quantity']; ?></td>
					<td><?php echo number_format($unitprice,2); ?>€</td>
					<td><?php echo number_format($price,2); ?>€</td>
				</tr>
				<?php endforeach; ?>
				<tr class="smallpad">
					<td colspan="4" class="noborder"></td>
					<td class="black">Delivery:</td>
					<td><?php echo number_format($deliveryPrice, 2); ?>€</td>
				</tr>
				<tr class="smallpad">
					<td colspan="4" class="noborder"></td>
					<td class="black">Total:</td>
					<td><?php echo number_format($infoscommande->order_price + $deliveryPrice, 2); ?>€</td>
				</tr>
				</tbody>
			</table>

			<table>
				<tr>
					<td>
						<br/><br/>
						<small>
							* All prices include TVA (19,6%)
						</small>
					</td>
				</tr>
			</table>

		</page>

		<?php
		$content = ob_get_clean();
		require(_APP_PATH . 'ext_lib/html2pdf/html2pdf.class.php');

		try {
			$pdf = new HTML2PDF('P', 'A4', 'fr');
			$pdf->writeHTML($content);
			$pdf->Output(_WWW_PATH . 'uploads/factures/facture_' . $infoscommande->order_hash . '.pdf', 'F');
		} catch(HTML2PDF_exception $e) {
			die($e);
		}

	}
}
?>