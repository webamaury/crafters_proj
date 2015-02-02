<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>

	<!-- /content -->
	<div class="container" xmlns="http://www.w3.org/1999/html">
		<div class="row">
			<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="modalities">Summary of your bag</span>
					</div>
					<div class="panel-body">
						<div class="maxheight400">
							<?php
							//var_dump($_SESSION[_SES_NAME]['Cart']);
							foreach ($_SESSION[_SES_NAME]['Cart'] as $key => $product) {
							?>
								<div id="product<?php echo $key; ?>" class="col-md-12 ajax_row">
									<div class="col-md-3"><img src="<?php echo $product['img_url']; ?>" class="img-responsive"></div>
									<div class="col-md-6 description-achat">
										<br>
										<p>
											<strong><?php echo $product['name']; ?></strong>
										</p>
										<p>
											<small>From <?php echo $product['from']; ?></small>
										</p>
										<p>
											<small>Quantity:
												<span class="ajax_quantity_display<?php echo $key; ?>"><?php echo $product['quantity']; ?></span>
												<a href="index.php?module=panier&amp;action=changeQuantity&amp;move=less&amp;product=<?php echo $key; ?>" class="ajax_quantity_trigger" data-id="<?php echo $key; ?>"><i class="fa fa-minus-square"></i></a>
												<a href="index.php?module=panier&amp;action=changeQuantity&amp;move=more&amp;product=<?php echo $key; ?>" class="ajax_quantity_trigger" data-id="<?php echo $key; ?>"><i class="fa fa-plus-square"></i></a>
											</small>
										</p>
										<p>
											<small>
												<span class="size_title">Size: </span>
												<span data-id="<?php echo $key; ?>" data-size="s" class="size_s<?php echo $key; ?> size_cart ajax_size_trigger">s</span>
												<span data-id="<?php echo $key; ?>" data-size="m" class="size_m<?php echo $key; ?> size_cart size_cart_select">m</span>
												<span data-id="<?php echo $key; ?>" data-size="l" class="size_l<?php echo $key; ?> size_cart ajax_size_trigger">l</span>
											</small>
										</p>
									</div>
									<div class="col-md-2">
										<br><br>
										<p class="price">10$</p>
									</div>
									<br><br>
									<div class="col-md-1">
										<a href="index.php?module=panier&amp;action=deleteFromCart&amp;product=<?php echo $key; ?>" class="ajax_delete_trigger"><i class="fa fa-trash-o"></i></a>
									</div>
								</div>
							<?php
							}
							?>
						</div>


						<div class="col-md-12">
							<hr>
							<div class="col-md-6">
								<span class="ajax_all_quantity"><?php echo $all_quantity; ?> products</span>
							</div>
							<div class="col-md-6 text-right">
								Total : <span class="ajax_all_price"><?php echo $totalPrice; ?></span> €
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-md-6">
				<h3 class="text-center">Please tell us about where you live</h3>
				<p class="text-center lead">We don't share those informations with anyone but we certainly need them to send you your work</p>
				<br/>

				<form action="index.php?module=commande&action=payWithPaypal" method="post">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2">
							<br/>
							<div class="col-md-12">
								<input type="text" placeholder="Adress" class="form-control" name="address" maxlength="100" required>
								<br/>
							</div>

							<div class="col-md-6">
								<input type="text" placeholder="Zipcode" class="form-control" name="zipcode" maxlength="10" required>
								<br/>
							</div>
							<div class="col-md-6">
								<input type="text" placeholder="City" class="form-control" name="city" maxlength="45" required>
								<br/>
							</div>
							<div class="col-md-12">
								<input type="text" placeholder="Country" class="form-control" value="France" required readonly>
								<br>
							</div>
							<div class="col-md-12">
								<textarea placeholder="More infos..." class="form-control" name="more" maxlength="100"></textarea>
							</div>

						</div>

						<div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2">
							<div class="col-md-12">
								<label class="radio-inline">
									<br/>
									<input type="radio" name="optradio" value="1" required>I agree with the Terms of Service
								</label>
							</div>
						</div>
						<div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
							<br/>
							<input type="submit" class="btn btn-md btn-primary center-block" value="Pay with Paypal">
							<br>
						</div>
					</div>
				</form>



			</div>
		</div>

	</div>
	<!-- /content -->

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