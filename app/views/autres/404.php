<?php include("../app/views/includes/head.inc.php") ; ?>
	

		<?php include("../app/views/includes/header.inc.php"); ?>
		
		<div class="container content">
			<div class="center-block padding-bot" style="margin: 0;">
				<br/>
				<br/>
				<h2 class="error404">ERROR<br><span class="size404">404</span></h2>

				<h2 style="font-size: 20px; text-align: center; margin-top: 30px;">What are you looking for ?</h2>
				<br />
				<div class="text-center">
					<?php
					if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
						?>
						<a href="index.php?module=upload" class="btn upload-2 upload-2c star">Start uploading your work</a>
					<?php
					} else {
						?>
						<a href="#" data-toggle="modal" data-target="#modal-login" class="btn upload-2 upload-2c star">Start uploading your work</a>
					<?php
					}
					?>
				</div>

			</div>
		</div>

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>