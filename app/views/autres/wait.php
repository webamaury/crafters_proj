<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crafters</title>
	<link href="css/wait.css" rel="stylesheet" type="text/css"/>
	<link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400' rel='stylesheet' type='text/css'>
</head>

<body>
<div id="container">

	<img id="logo" src="img/logo.png" alt="logo" />
	<h3>Crafters will be launch soon.</h3>

	<div id="content">

		<div class="block">
			<div class="num">
				<span class="numb" id="days_js">60</span>
			</div>
			<div class="text">
				<span id="days_label_js" class="textb">DAYS</span>
			</div>
		</div>

		<div class="block">
			<div class="num">
				<span class="numb" id="hours_js">05</span>
			</div>
			<div class="text">
				<span id="hours_label_js" class="textb">HOURS</span>
			</div>
		</div>

		<div class="block">
			<div class="num">
				<span class="numb" id="minutes_js">27</span>
			</div>
			<div class="text">
				<span id="minutes_label_js" class="textb">MINUTES</span>
			</div>
		</div>

		<div class="block">
			<div class="num">
				<span class="numb" id="seconds_js">36</span>
			</div>
			<div class="text">
				<span id="seconds_label_js" class="textb">SECONDS</span>
			</div>
		</div>

		<div id="formu">
			<form role="form" action="index.php" method="post">
				<input type="email" id="email" name="mail_notif" placeholder="Email address" required>
				<button class="button" type="submit">Notify Me</button>
			</form>
			<?php if (isset($_GET['mess']) && $_GET['mess'] == 'good') {
				echo '<br/><small>Your email has been recorded! You will be notify when Crafters will launch.</small>';
			} else if (isset($_GET['mess']) && $_GET['mess'] == 'already') {
				echo '<br/><small>This email is already recorded! You will be notify when Crafters will launch.</small>';
			} ?>
		</div>

	</div>

</div>
<script type="text/javascript" src="js/countdown.js"></script>
<script type="text/javascript">
	compte_a_rebours();
</script>
</body>
</html>
