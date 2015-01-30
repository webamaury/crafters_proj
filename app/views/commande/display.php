<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>

	<!-- /content -->
	<div class="container">

		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="modalities">Summary of your bag</span>
					</div>
					<div class="panel-body">
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


						<!--<div class="col-md-12 summary-block">
							<div class="col-md-3">
								<img src="illu/12.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								Super Clown from Ian
								<br/>
								<span class="summary">Type: Tattoo</span><br/>
								<span class="summary">Size: M</span><br/>
								<span class="summary">Quantity: 2</span><br/>
							</div>
							<div class="col-md-4">
								<br/>
								<span class="summary">Price: 8$</span><br/>
								<span class="summary">Total: 16$</span><br/>
								<div class="btn btn-danger btn-xs">Modify <i class="fa fa-wrench"></i></div>
							</div>
						</div>

						<div class="col-md-12 summary-block">
							<div class="col-md-3">
								<img src="illu/11.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								Super Clown from Ian
								<br/>
								<span class="summary">Type: Tattoo</span><br/>
								<span class="summary">Size: M</span><br/>
								<span class="summary">Quantity: 2</span><br/>
							</div>
							<div class="col-md-4">
								<br/>
								<span class="summary">Price: 8$</span><br/>
								<span class="summary">Total: 16$</span><br/>
								<div class="btn btn-danger btn-xs">Modify <i class="fa fa-wrench"></i></div>
							</div>
						</div>

						<div class="col-md-12 summary-block">
							<div class="col-md-3">
								<img src="illu/stickers/11.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								Sunset Boulevard
								<br/>
								<span class="summary">Type: Stickers</span><br/>
								<span class="summary">Size: L</span><br/>
								<span class="summary">Quantity: 1</span><br/>
							</div>
							<div class="col-md-4">
								<br/>
								<span class="summary">Price: 15$</span><br/>
								<span class="summary">Total: 15$</span><br/>
								<div class="btn btn-danger btn-xs">Modify <i class="fa fa-wrench"></i></div>
							</div>
						</div>-->

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

				<div class="row">
					<div class="col-md-4 col-md-offset-2 col-sm-4 col-xs-4 col-xs-offset-2">
						<input type="text" placeholder="Firstname" class="form-control">
					</div>
					<div class="col-md-4  col-sm-4 col-xs-4">
						<input type="text" placeholder="Lastname" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2">
						<br/>
						<input type="text" placeholder="Adress" class="form-control">
						<br/>
						<div class="col-md-6">
							<input type="text" placeholder="Zipcode" class="form-control">
							<br/>
						</div>
						<div class="col-md-6">
							<input type="tel" placeholder="Phone number" class="form-control">
							<br/>
						</div>
						<input type="text" placeholder="City" class="form-control">
						<br/>
						<input type="text" placeholder="Country" class="form-control">
					</div>

					<div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2">
						<form role="form">
							<label class="radio-inline">
								<br/>
								<input type="radio" name="optradio">I agree with the Terms of Service
							</label>
						</form>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
						<br/>
						<btn class="btn btn-md btn-primary center-block" data-toggle="modal" data-target="#modal-validation"><a href="#">Pay with Paypal</a></btn>
						<br>
					</div>
				</div>




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