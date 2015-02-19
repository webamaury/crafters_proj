<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<div class="container">

	<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>


	<div class="container">
		<div class="row">	
			<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>	
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-5 col-lg-4">
				<div class="row">
					<div class="col-md-4 header_video text-center">
						<iframe id="ytplayer" type="text/html" width="354" height="199"
						        src="https://www.youtube.com/embed/hzbq6XM9zTU?autoplay=0&controls=0&fs=0&modestbranding=1&rel=0&showinfo=0&autohide=1&color=white&theme=light"
						        frameborder="0" allowfullscreen>
						</iframe>
						<br>
						<?php
						if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
							?>
							<a href="index.php?module=upload" class="btn upload-2 upload-2c star">Start uploading your work</a>
						<?php
						} else {
							?>
							<a href="#" data-toggle="modal" data-target="#modal-login" class="btn upload-2 upload-2c star">Start uploading your work</a>
						<?php
						}
						?>
						<br>
						<br/>
						<br/>
					</div>

					<div class="col-xs-12">
						<h2 style="text-transform: uppercase; font-size: 20px; ">Crafter of the month</h2>
						<hr>
					</div>
					<div class="col-xs-12">
						<div class="col-md-5 col-sm-3 col-xs-3">
							<a href="<?php echo (_REW_URL == true) ? "/profile=>" . $crafter_of_month->user_id : _PATH_FOLDER . "index.php?module=profile&user=" . $crafter_of_month->user_id ; ?>">
								<img src="<?php echo $crafter_of_month->user_img_url; ?>" class="img-responsive img-circle" alt="Avatar <?php echo $crafter_of_month->user_username; ?> | Crafters" style="float: right">
							</a>
						</div>

						<div class="col-md-7 col-sm-9 col-xs-9">
							<br/>
							<a href="<?php echo (_REW_URL == true) ? "/profile=>" . $crafter_of_month->user_id : _PATH_FOLDER . "index.php?module=profile&user=" . $crafter_of_month->user_id ; ?>">
								<h2><?php echo $crafter_of_month->user_username; ?></h2>
							</a>
							<p><?php echo $crafter_of_month->user_description; ?></p>
							<?php foreach ($user_month_products as $user_month_product) { ?>
								<img src="<?php echo $user_month_product->product_img_url; ?>"
								     alt="Temporary Tattoo <?php echo $user_month_product->product_name; ?> | Crafters"
								     title="<?php echo $user_month_product->product_name; ?>" width="40">
							<?php } ?>
							<br/>
							<span onclick="ga('send','event','Crafter of the month','Clique');" class="seemore"><a
									href="index.php?module=profile&user=<?php echo $crafter_of_month->user_id; ?>">See
									her creations</a></span>
							<br/>
							<br/>
							<br/>
						</div>
					</div>
					<div class="col-xs-12">
						<h2 style="text-transform: uppercase; font-size: 20px; ">Most Popular Crafters</h2>
						<hr>
					</div>
					<?php
					foreach ($popular_crafters as $popular_crafter) {
						?>
						<div class="col-xs-12">
							<div class="col-md-3 col-sm-2 col-xs-2">
								<a href="<?php echo (_REW_URL == true) ? "/profile=>" . $popular_crafter->user_id_product : _PATH_FOLDER . "index.php?module=profile&user=" . $popular_crafter->user_id_product ; ?>">
									<img src="<?php echo $popular_crafter->user_img_url; ?>" alt="Avatar <?php echo $popular_crafter->user_username; ?> | Crafters" class="img-responsive img-circle" style="float: right"></a>
							</div>
							<div class="col-md-9 col-sm-10 col-xs-10">
								<br/>
								<a href="index.php?module=profile&user=<?php echo $popular_crafter->user_id_product; ?>">
									<h2><?php echo $popular_crafter->user_username; ?></h2>
								</a>
								<?php
								foreach ($popular_crafter->creas as $popular_crafter->crea) {
									?>
									<img src="<?php echo $popular_crafter->crea->product_img_url; ?>"
									     alt="Temporary Tattoo <?php echo $popular_crafter->crea->product_name; ?> | Crafters"
									     title="<?php echo $popular_crafter->crea->product_name; ?>" width="30">
								<?php
								}
								?>
								<br/>
								<span class="seemore">
									<a href="index.php?module=profile&user=<?php echo $popular_crafter->user_id_product; ?>">See his creations</a>
								</span>
								<br/>
								<br/>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>


			<div class="col-sm-12 col-md-7 col-lg-8 container big-gallery">
				<div class="col-xs-12 big-container">
					<span class="title-gallery">CRaFTERS LaST UPLOaD</span>
					<form action="index.php" method="get" class="navbar-form navbar-right" role="search">
						<div class="input-group input-group-sm">
							<input type="hidden" name="module" value="gallery">
							<input type="text"  pattern=".{3,20}" required title="3 to 20 characters" class="form-control" name="search" placeholder="Search for...">
							<span class="input-group-btn">

								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
				</div>

				<div class="col-xs-12">
					<div id="display_load_more" class="row">

						<?php
						foreach ($products as $product) {
							?>
							<div class="col-sm-4 col-md-4 col-xs-6 col-lg-3">
								<div class="thumbnail parent">
									<a href="<?php echo (_REW_URL == true) ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>" class="product-image">
										<img src="<?php echo $product->product_img_url; ?>" class="img-responsive prodIMG" alt="Temporary Tattoo <?php echo $product->product_name; ?> | Crafters">
									</a>

									<div class="caption">
										<h4><?php echo $product->product_name; ?></h4>

										<p>
											<small><em>By <?php echo $product->user_username; ?></em></small>
										</p>
										<div class="btn-group " style="float: left">
											<a href="<?php echo (_REW_URL == true) ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
											<a href="index.php?module=panier&action=addToCart&product=<?php echo $product->product_id; ?>&img_url=<?php echo $product->product_img_url; ?>&name=<?php echo $product->product_name; ?>&from=<?php echo $product->user_username; ?>" class="btn btn-xs ajax_cart_trigger btn-default add-to-cart"><i class="fa fa-shopping-cart"></i></a>
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
						?>
					</div>
					<div class="btn-group btn-group-justified" role="group" aria-label="...">
						<div class="btn-group" role="group">
							<a href="index.php?module=gallery" id="load_more" data-num="1" class="btn btn-default">load more...</a>
						</div>
					</div>
				</div>
			</div>
		</div>



	</div>
	<!-- /container -->
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