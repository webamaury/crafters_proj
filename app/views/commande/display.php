<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>

	<!-- /content -->
	<div class="container" xmlns="http://www.w3.org/1999/html">
		<div class="row">
			<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
		</div>
		<div class="row">
			<form action="index.php?module=commande&action=payWithPaypal" method="post">

				<div class="col-md-7 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="modalities">Summary of your bag</span>
						</div>
						<div class="panel-body">
							<div class="maxheight400">
								<?php
								//var_dump($_SESSION[_SES_NAME]['Cart']);
								foreach ($_SESSION[_SES_NAME]['Cart'] as $key => $product) {
								//var_dump($product);
								?>
								<div id="product<?php echo $key; ?>" class="col-md-12 ajax_row">
										<div class="col-md-3"><img src="<?php echo $product['img_url']; ?>" class="img-responsive"></div>
										<div class="col-md-6 description-achat">
											<p class="col-xs-12">
												<strong><?php echo $product['name']; ?></strong>
											</p>
											<p class="col-xs-12">
												<small>From <?php echo $product['from']; ?></small>
											</p>
											<p class="col-xs-12">
												<small>Quantity:
													<span class="ajax_quantity_display<?php echo $key; ?>"><?php echo $product['quantity']; ?></span>
													<a href="index.php?module=panier&amp;action=changeQuantity&amp;move=less&amp;product=<?php echo $key; ?>" class="ajax_quantity_trigger" data-id="<?php echo $key; ?>"><i class="fa fa-minus-square"></i></a>
													<a href="index.php?module=panier&amp;action=changeQuantity&amp;move=more&amp;product=<?php echo $key; ?>" class="ajax_quantity_trigger" data-id="<?php echo $key; ?>"><i class="fa fa-plus-square"></i></a>
												</small>
											</p>
											<p class="col-xs-12">
												<small>
													<span class="size_title">Size: </span>
													<span data-id="<?php echo $key; ?>" data-size="s" class="size_s<?php echo $key; ?> size_cart<?php
													if ($product['size'] == 's') {
														$prodprice = '5€';
														echo ' size_cart_select';
													} else {
														echo ' ajax_size_trigger';
													}
													?>">s</span>
													<span data-id="<?php echo $key; ?>" data-size="m" class="size_m<?php echo $key; ?> size_cart<?php
													if ($product['size'] == 'm') {
														$prodprice = '10€';
														echo ' size_cart_select';
													} else {
														echo ' ajax_size_trigger';
													}
													?>">m</span>
													<span data-id="<?php echo $key; ?>" data-size="l" class="size_l<?php echo $key; ?> size_cart<?php
													if ($product['size'] == 'l') {
														$prodprice = '15€';
														echo ' size_cart_select';
													} else {
														echo ' ajax_size_trigger';
													}
													?>">l</span>
												</small>
											</p>
											<p class="col-xs-12 type_cart_content">
												<small>
													<span data-id="<?php echo $key; ?>" data-type="Tattoo" class="type_t<?php echo $key; ?> type_cart<?php
													if ($product['type'] == 'Tattoo') {
														echo ' type_cart_select';
													} else {
														echo ' ajax_type_trigger';
													}
													?>">Tattoo</span>
													<span data-id="<?php echo $key; ?>" data-type="Stickers" class="type_s<?php echo $key; ?> type_cart<?php
													if ($product['type'] == 'Stickers') {
														echo ' type_cart_select';
													} else {
														echo ' ajax_type_trigger';
													}
													?>">Stickers</span>
												</small>
											</p>

										</div>
										<div class="col-md-2">
											<br><br>
											<p class="price"><?php echo $prodprice; ?></p>
										</div>
										<div class="col-md-1">
											<br><br>
											<a href="index.php?module=panier&amp;action=deleteFromCart&amp;product=<?php echo $key; ?>" class="ajax_delete_trigger"><i class="fa fa-trash-o"></i></a>
										</div>
									</div>
								<?php
								}
								?>
							</div>

							<div class="col-xs-12">
								<br/>Delivery:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label class="radio-inline">
									<input type="hidden" name="delivery_ajax" class="delivery_ajax" action="<?php echo $delivery; ?>">
									<input type="radio" name="delivery" id="inlineRadio1" value="0"<?php echo ($delivery == 0) ? " checked" : "" ; ?>> Normal (6€)
								</label>
								<label class="radio-inline">
									<input type="radio" name="delivery" id="inlineRadio2" value="1"<?php echo ($delivery == 1) ? " checked" : "" ; ?>> Express (10€)
								</label>
							</div>

							<div class="col-xs-12">
								<hr>
								<div class="col-xs-6">
									<span class="ajax_all_quantity"><?php echo $all_quantity; ?> products</span>
								</div>
								<div class="col-xs-6 text-right">
									Total : <span class="ajax_all_price"><?php echo $totalPrice + $deliveryPrice; ?></span> €
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="col-md-5 col-xs-12">
					<h3 class="text-center">Delivery Address</h3>

					<div class="col-xs-12">
						<br/>
						<div class="col-md-6">
							<input type="text" placeholder="Firstname" class="form-control" value="<?php echo $_SESSION[_SES_NAME]['firstname']; ?>" name="firstname" maxlength="20" required>
							<br/>
						</div>
						<div class="col-md-6">
							<input type="text" placeholder="Name" class="form-control" value="<?php echo $_SESSION[_SES_NAME]['name']; ?>" name="name" maxlength="30" required>
							<br/>
						</div>

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
					<div class="col-xs-12">
						<div class="col-md-12">
							<label class="radio-inline">
								<br/>
								<input type="radio" name="optradio" value="1" required>I agree with the Terms of Service
							</label>
						</div>
					</div>
					<div class="col-xs-12">
						<br/>
						<input type="submit" class="btn btn-md btn-primary center-block" value="Delivery">
						<br>
					</div>




				</div>
			</form>
		</div>

	</div>
	<!-- /content -->

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>