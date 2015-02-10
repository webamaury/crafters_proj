<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

	<!-- container -->
	<div class="container">

		<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>

		<div class="container">
			<a href="<?php echo $paypalurl; ?>" class="btn btn-primary">Pay With Paypal</a>
		</div>
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