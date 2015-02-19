<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

	<!-- container -->
	<div class="container">

		<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>


		<div class="container">
			<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
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
	<!-- /container -->

	<script type="text/javascript" src="tools/jQuery/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="tools/bootstrap-3.2.0/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".confirm_password").on("keyup", function(){
				var value = $(this).val();
				var new_mail = $('.new_password').val();
				$(this).attr("pattern", new_mail)

				if (value == new_mail) {
					$(this).parents("div.form-group").removeClass("has-error");
					$(this).parents("div.form-group").addClass("has-success");
				} else {
-					$(this).parents("div.form-group").removeClass("has-success");
					$(this).parents("div.form-group").addClass("has-error");
				}
				if (value == "") {
					$(this).parents("div.form-group").removeClass("has-error");
					$(this).parents("div.form-group").removeClass("has-success");
				}
			})
		});
	</script>
	<script>
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function () {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-56403954-1', 'auto');
		ga('send', 'pageview');

	</script>
	<script type="text/javascript" src="js/list.js"></script>
	<script type="text/javascript" src="js/loadmore.js"></script>
<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>