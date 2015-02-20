<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>

	<!--Content-->
	<div class="row content">

		<div class="container">

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

	</div>
	<!--/Content-->

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>