<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>


	<div class="container">

		<div class="row">
			<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
		</div>

		<div class="row">
			<div class="text-center">
				<h3>Set new password for <?php echo $return->user_mail; ?></h3>
			</div>
			<br/>
			<div class="col-xs-12 col-md-4 col-md-offset-4">
				<form method="post" action="index.php?module=profile">
					<div class="form-group">
						<label class="control-label" for="new_password">New password</label>
						<input type="password" name="new_password" id="new_password" class="form-control new_password" required pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" title="Uppercase, lowercase, number.">
					</div>
					<div class="form-group">
						<label class="control-label" for="confirm_password">Confirm password</label>
						<input type="password" name="confirm_password" id="confirm_password" class="form-control confirm_password" required title="Confirmation is not good">
					</div>
					<br/>
					<input type="hidden" name="action" value="newPassword">
					<input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>">
					<button type="submit" class="btn btn-danger pull-right">Send</button>
				</form>
			</div>


		</div>

	</div>

	<script type="text/javascript" src="js/valid.form.js"></script>

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>