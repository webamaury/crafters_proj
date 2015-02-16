<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

	<!-- container -->
	<div class="container">

		<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>
		<!-- /content -->
		<div class="container" xmlns="http://www.w3.org/1999/html">
			<div class="row">
				<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
			</div>
			<div class="row">
				<form action="index.php?module=commande&action=payWithPaypal" method="post">


					<div class="col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<span class="modalities">Choose your payment mode</span>
							</div>
							<div class="panel-body text-center">
								<div class="col-md-6 col-xs-12">
									<h4>CREDIT CARD</h4>
									<br/><br/>
									<p class="col-xs-10 col-xs-offset-1">
										You can pay with your credit card using Paypal!<br/><br>
										You don't need any account.<br/>
										<br>
										It is safe and secure!<br/><br>
										<small>Your order will be send asap.</small>
									</p>
									<div class="col-xs-12"><br>
										<a class="btn btn-primary" href="<?php echo $paypalurl; ?>"><i class="fa fa-paypal"></i> Pay with Paypal</a>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<h4>CHECK</h4>
									<br/><br>
									<p class="col-xs-10 col-xs-offset-1">
										You can send us a check to the account of Crafters at:<br/><br>
										Crafters<br/>
										28 place de la Bourse<br/>
										75002 Paris<br/><br/>
										<small>Your order will be send after the reception of the check.</small>
									</p>
									<div class="col-xs-12"><br>
										<a class="btn btn-primary" href="index.php?module=commande&action=payCheck"><i class="fa fa-list-alt"></i> Send a check</a>
									</div>
								</div>
							</div>
						</div>
					</div>

				</form>
			</div>

		</div>
		<!-- /content -->
	</div>
	<!-- /container -->

	<script type="text/javascript" src="tools/jQuery/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="tools/bootstrap-3.2.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="tools/jQueryUI-1.11.1/jquery-ui.min.js"></script>
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