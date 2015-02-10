<?php include("../app/views/includes/head.inc.php") ; ?>

<div class="container">

<?php include("../app/views/includes/header.inc.php"); ?>

	<div class="container messagepage">
		<div class="col-md-8 col-xs-12 col-md-offset-2 text-center">
			<div class="col-xs-12 messagepageicon"><?php echo $icon; ?></div>
			<div class="col-xs-12 messagepageheader"><?php echo $header; ?></div>
			<div class="col-xs-12 messagepagecontent"><?php echo $content; ?></div>
		</div>
	</div>

	<script type="text/javascript" src="tools/jQuery/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="tools/bootstrap-3.2.0/js/bootstrap.min.js"></script>
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

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>