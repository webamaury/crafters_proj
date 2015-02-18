<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

	<!-- container -->
	<div class="container">

		<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>


		<div class="container">
			<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>

			<?php //var_dump($craft, $crafter, $products); ?>


			<div class="row parent">
				<div class="col-md-4 col-md-offset-2 col-sm-4 col-xs-12">
					<img src="<?php echo _PATH_FOLDER . str_replace("thumb_", "", $craft->product_img_url); ?>" class="img-responsive img-polaroid prodIMG">
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12 product_infos" >
					<div class="row">
						<div class="col-md-6">
							<span class="namedesign"><?php echo $craft->product_name; ?></span><br/>
							<span class="designedby">Designed by <?php echo $crafter->user_username; ?></span>
						</div>
						<div class="col-md-6 text-center">
							<br/>
							<?php
							if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
								if (isset($craft->did_i_like) && $craft->did_i_like == true) {
									?>
									<button type="button"
									        data-product="<?php echo $craft->product_id; ?>"
									        class="btn btn-xs btn-default like ajax_like_trigger"
									        data-didilike="1">
														<span class="nb_like"
														      id="nb_like<?php echo $craft->product_id; ?>"><?php echo $craft->nb_like; ?></span>
										<i data-toggle="tooltip" data-placement="top" data-html="true"
										   title="<?php
										   if (isset($craft->name_likes)) {
											   foreach ($craft->name_likes as $craft->name_like) {
												   echo $craft->name_like->user_username . '<br/>';
											   }
											   if ($craft->nb_like > 5) {
												   $others = $craft->nb_like - 5;
												   echo 'and ' . $others . ' others';
											   }
										   }
										   ?>" class="fa fa-heart" style="color: tomato"></i>
									</button>
								<?php
								} else {
									?>
									<button type="button"
									        data-product="<?php echo $craft->product_id; ?>"
									        class="btn btn-xs btn-default like ajax_like_trigger"
									        data-didilike="0">
														<span class="nb_like"
														      id="nb_like<?php echo $craft->product_id; ?>"><?php echo $craft->nb_like; ?></span>
										<i data-toggle="tooltip" data-placement="top" data-html="true"
										   title="<?php
										   if (isset($craft->name_likes)) {
											   foreach ($craft->name_likes as $craft->name_like) {
												   echo $craft->name_like->user_username . '<br/>';
											   }
											   if ($craft->nb_like > 5) {
												   $others = $craft->nb_like - 5;
												   echo 'and ' . $others . ' others';
											   }
										   }
										   ?>" class="fa fa-heart-o" style="color: tomato"></i>
									</button>
								<?php
								}
							} else {
								?>
								<button data-toggle="modal" data-target="#modal-login" type="button"
								        data-product="<?php echo $craft->product_id; ?>"
								        class="btn btn-xs btn-default like">
													<span class="nb_like"
													      id="nb_like<?php echo $craft->product_id; ?>"><?php echo $craft->nb_like; ?></span>
									<i data-toggle="tooltip" data-placement="top" data-html="true"
									   title="<?php
									   if (isset($craft->name_likes)) {
										   foreach ($craft->name_likes as $craft->name_like) {
											   echo $craft->name_like->user_username . '<br/>';
										   }
										   if ($craft->nb_like > 5) {
											   $others = $craft->nb_like - 5;
											   echo 'and ' . $others . ' others';
										   }
									   }
									   ?>" class="fa fa-heart-o" style="color: tomato"></i>
								</button>
							<?php
							}
							?>
						</div>
					</div>
					<hr>
					<p><strong>Description:</strong> <em><?php echo $craft->product_description; ?></em> </p>
					<br/>
					<br/>
					<br/>
					<a href="<?php echo _PATH_FOLDER; ?>index.php?module=panier&action=addToCart&product=<?php echo $craft->product_id; ?>&img_url=<?php echo $craft->product_img_url; ?>&name=<?php echo $craft->product_name; ?>&from=<?php echo $crafter->user_username; ?>"  class="btn btn-sm btn-danger ajax_cart_trigger add-to-cart">I WANT IT !</a> <i data-toggle="tooltip" data-container="body" data-placement="right" title=" You can change the type (Tattoo or Stickers), size (s, m, l) and quantity in your shopping bag or your summary. Price depend on size: s = 5€ ; m = 10€ ; l = 15€" class="fa fa-info-circle"></i>
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="col-md-12">
					<h3>Other creation from <?php echo $crafter->user_username; ?> <a href="<?php echo (_REW_URL == true) ? "/profile=>" . $craft->user_id_product : _PATH_FOLDER . "index.php?module=profile&user=" . $craft->user_id_product ; ?>"><small>(see all)</small></a></h3>
				</div>
				<?php
				$i = 1;
				foreach ($products as $product) {
					if ($product->product_id != $craft->product_id && $i<=4) {
						$i++;
						?>

						<div class="col-sm-4 col-md-3 col-xs-6 col-lg-3">
							<div class="thumbnail parent">
								<a href="<?php echo (_REW_URL == true) ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>"
								   class="product-image"><img src="<?php echo _PATH_FOLDER . $product->product_img_url; ?>"
								                              class="img-responsive prodIMG"></a>

								<div class="caption">
									<h4><?php echo $product->product_name; ?></h4>

									<p>
										<small><em>By <?php echo $crafter->user_username; ?></em></small>
									</p>
									<div class="btn-group " style="float: left">
										<a href="<?php echo (_REW_URL == true) ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>"
										   class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
										<a href="index.php?module=panier&action=addToCart&product=<?php echo $product->product_id; ?>&img_url=<?php echo $product->product_img_url; ?>&name=<?php echo $product->product_name; ?>&from=<?php echo $crafter->user_username; ?>"
										   class="btn btn-xs ajax_cart_trigger btn-default add-to-cart"><i
												class="fa fa-shopping-cart"></i></a>
									</div>
									<div class="text-right"><?php
										if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
											if (isset($product->did_i_like) && $product->did_i_like == true) {
												?>
												<button type="button"
												        data-product="<?php echo $product->product_id; ?>"
												        class="btn btn-xs btn-default like ajax_like_trigger"
												        data-didilike="1">
														<span class="nb_like"
														      id="nb_like<?php echo $product->product_id; ?>"><?php echo $product->nb_like; ?></span>
													<i data-toggle="tooltip" data-placement="top" data-html="true"
													   title="<?php
													   if (isset($product->name_likes)) {
														   foreach ($product->name_likes as $product->name_like) {
															   echo $product->name_like->user_username . '<br/>';
														   }
														   if ($product->nb_like > 5) {
															   $others = $product->nb_like - 5;
															   echo 'and ' . $others . ' others';
														   }
													   }
													   ?>" class="fa fa-heart" style="color: tomato"></i>
												</button>
											<?php
											} else {
												?>
												<button type="button"
												        data-product="<?php echo $product->product_id; ?>"
												        class="btn btn-xs btn-default like ajax_like_trigger"
												        data-didilike="0">
														<span class="nb_like"
														      id="nb_like<?php echo $product->product_id; ?>"><?php echo $product->nb_like; ?></span>
													<i data-toggle="tooltip" data-placement="top" data-html="true"
													   title="<?php
													   if (isset($product->name_likes)) {
														   foreach ($product->name_likes as $product->name_like) {
															   echo $product->name_like->user_username . '<br/>';
														   }
														   if ($product->nb_like > 5) {
															   $others = $product->nb_like - 5;
															   echo 'and ' . $others . ' others';
														   }
													   }
													   ?>" class="fa fa-heart-o" style="color: tomato"></i>
												</button>
											<?php
											}
										} else {
											?>
											<button data-toggle="modal" data-target="#modal-login" type="button"
											        data-product="<?php echo $product->product_id; ?>"
											        class="btn btn-xs btn-default like">
													<span class="nb_like"
													      id="nb_like<?php echo $product->product_id; ?>"><?php echo $product->nb_like; ?></span>
												<i data-toggle="tooltip" data-placement="top" data-html="true"
												   title="<?php
												   if (isset($product->name_likes)) {
													   foreach ($product->name_likes as $product->name_like) {
														   echo $product->name_like->user_username . '<br/>';
													   }
													   if ($product->nb_like > 5) {
														   $others = $product->nb_like - 5;
														   echo 'and ' . $others . ' others';
													   }
												   }
												   ?>" class="fa fa-heart-o" style="color: tomato"></i>
											</button>
										<?php
										}
										?>



										<!--<button type="button" class="btn btn-xs btn-default like">
		                                    <span class="nb_like" id="nb_like<?php echo $product->product_id; ?>"><?php echo $product->nb_like; ?></span> <i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart" style="color: tomato"></i>
		                                </button>-->
									</div>
								</div>
							</div>
						</div>
					<?php
					}
				}

				?>
			</div>



		</div>
	</div>
	<!-- /container -->

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
	<script type="text/javascript" src="js/loadmore.js"></script>
<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>