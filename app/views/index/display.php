<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<div class="container">

	<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>


	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4">
				<div class="row">
					<div class="col-md-4 header_video">
						<iframe id="ytplayer" type="text/html" width="354" height="199"
						        src="https://www.youtube.com/embed/hzbq6XM9zTU?autoplay=0&controls=0&fs=0&modestbranding=1&rel=0&showinfo=0&autohide=1&color=white&theme=light"
						        frameborder="0" allowfullscreen>
						</iframe>
						<br>
						<?php
						if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
							?>
							<a href="index.php?module=upload" onclick="ga('send','event','Upload','Clique');"
							   class="btn upload-2 upload-2c star">Start uploading your work</a>
						<?php
						} else {
							?>
							<a href="#" onclick="ga('send','event','Upload','Clique');" data-toggle="modal"
							   data-target="#modal-login" class="btn upload-2 upload-2c star">Start uploading your
								work</a>
						<?php
						}
						?>
						<br>
						<br/>
						<br/>
					</div>
					<div class="row">

						<div class="col-md-12">
							<h2 style="text-transform: uppercase; font-size: 20px; ">Crafter of the month</h2>
							<hr>
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<a href="index.php?module=profil&user=
								<?php echo $crafter_of_month->user_id; ?>
							">
								<img src="
								<?php echo $crafter_of_month->user_img_url; ?>
								" class="img-responsive img-circle" style="float: right">
							</a>
						</div>
						<div class="col-md-6 col-sm-9 col-xs-7">
							<br/>
							<a onclick="ga('send','event','Crafter of the month','Clique');" href="#"></a>

							<h2><?php echo $crafter_of_month->user_username; ?></h2></a>
							<p><?php echo $crafter_of_month->user_description; ?></p>
							<?php foreach ($user_month_products as $user_month_product) { ?>
								<img src="<?php echo $user_month_product->product_img_url; ?>"
								     alt="<?php echo $user_month_product->product_name; ?>"
								     title="<?php echo $user_month_product->product_name; ?>" width="40px">
							<?php } ?>
							<br/>
							<span onclick="ga('send','event','Crafter of the month','Clique');" class="seemore"><a
									href="index.php?module=profil&user=<?php echo $crafter_of_month->user_id; ?>">See
									her creations</a></span>
							<br/>
							<br/>
							<br/>
						</div>

						<div class="col-md-12 ">
							<h2 style="text-transform: uppercase; font-size: 20px; ">Most Popular Crafters</h2>
							<hr>
						</div>
						<?php
						foreach ($popular_crafters as $popular_crafter) {
							?>
							<div class="col-md-3 col-sm-3 col-xs-3">
								<a href="index.php?module=profil&user=<?php echo $popular_crafter->user_id_product; ?>"><img
										src="<?php echo $popular_crafter->user_img_url; ?>"
										class="img-responsive img-circle" style="float: right"></a>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-7">
								<br/>
								<a href="index.php?module=profil&user=<?php echo $popular_crafter->user_id_product; ?>">
									<h2><?php echo $popular_crafter->user_username; ?></h2></a>
								<?php
								foreach ($popular_crafter->creas as $popular_crafter->crea) {
									?>
									<img src="<?php echo $popular_crafter->crea->product_img_url; ?>"
									     alt="<?php echo $popular_crafter->crea->product_name; ?>"
									     title="<?php echo $popular_crafter->crea->product_name; ?>" width="30px">
								<?php
								}
								?>

								<br/>
								<span class="seemore"><a
										href="index.php?module=profil&user=<?php echo $popular_crafter->user_id_product; ?>">See
										his creations</a></span>
								<br/>
								<br/>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>


			<div class="container big-gallery">
				<div class="col-sm-8 col-md-8 big-container">
					<span class="title-gallery">CRaFTERS LaST UPLOaD</span>
					<!--<form class="navbar-form navbar-right" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form>-->
				</div>

				<div class="col-sm-6 col-md-8">
					<div id="display_load_more" class="row">

						<?php
						foreach ($products as $product) {
							?>
							<div class="col-sm-6 col-md-4 col-xs-6 col-lg-3">
								<div class="thumbnail">
									<a onclick="ga('send','event','Gallery','Clique');"
									   href="index.php?module=fiche&product=<?php echo $product->product_id; ?>" class="product-image"><img
											src="<?php echo $product->product_img_url; ?>" class="img-responsive"></a>

									<div class="caption">
										<h4><?php echo $product->product_name; ?></h4>

										<p>
											<small><em>By <?php echo $product->user_username; ?></em></small>
										</p>
										<div class="btn-group " style="float: left">
											<a href="index.php?module=fiche&product=<?php echo $product->product_id; ?>"
											   class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
											<a href="index.php?module=panier&action=addToCart&product=<?php echo $product->product_id; ?>&img_url=<?php echo $product->product_img_url; ?>&name=<?php echo $product->product_name; ?>&from=<?php echo $product->user_username; ?>" class="btn btn-xs ajax_cart_trigger btn-default add-to-cart"><i
													class="fa fa-shopping-cart"></i></a>
											<!--<button type="button" data-product="<?php echo $product->product_id; ?>" <?php
											if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
												if ($product->did_i_like == true) {
													echo 'class="btn btn-xs btn-default btn-primary like2 btn-tomato ajax_like_trigger" data-didilike="1"';
												} else {
													echo 'class="btn btn-xs btn-default btn-primary like2 ajax_like_trigger" data-didilike="0"';
												}
											} else {
												echo 'class="btn btn-xs btn-default btn-primary like2"  data-toggle="modal" data-target="#modal-login"';
											} ?>
				                             ><i class="fa fa-heart-o"></i></button>-->
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
							<a type="button" id="load_more" data-num="1" class="btn btn-default">load more...</a>
						</div>
					</div>
					<!--<div class="col-md-12 text-center">
						<a id="load_more" data-num="1" href="#">load more...</a>
					</div>-->
				</div>
			</div>
		</div>


		<div class="modal" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label"
		     aria-hidden="true" style="padding-top: 100px;">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="modal-login-label">Log in</h4>
					</div>
					<div class="modal-body">
						<div class="row center-block">
							<div class="col-md-12">

								<h3>Please Log In, or <a href="#" data-toggle="modal" data-target="#modal-new-signup">Sign
										Up</a></h3>

								<form role="form" method="post"
								      action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
									<div class="form-group">
										<input type="text" name="email" placeholder="Username or Email"
										       class="form-control" required>
										<br/>
										<input type="password" name="password" placeholder="Password"
										       class="form-control" required>
									</div>
									<!--<a class="pull-right" href="#">Forgot password?</a>-->
									<input type="hidden" name="action" value="login"/>
									<button type="submit" class="btn btn btn-primary">
										Log In
									</button>
								</form>
								<!--<div class="login-or">
									<hr class="hr-or">
									<span class="span-or">or</span>
								</div>-->
								<div class="row">
									<!--<div class="col-xs-12 col-sm-12 col-md-12">
										<a href="#" class="btn btn-lg btn-block" style="background-color: #3b5998; border-color: #3b5998; color: white">Facebook</a>
									</div>-->
									<div class="col-xs-12 col-sm-12 col-md-12 text-center">
										<br/>
										<a href="#" class="new-signup">New on Crafters ? Subscribe</a>
									</div>
								</div>

							</div>

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->


		<!-- CREDIT CARD - SHOPPING BAG -->
		<div class="modal" id="modal-shoppingbag" tabindex="-1" role="dialog" aria-labelledby="modal-shoppingbag-label"
		     aria-hidden="true" style="padding-top: 100px;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="modal-shoppingbag-label">Your shopping bag</h4>
					</div>
					<div class="modal-body">
						<div class="row center-block">
							<div class="col-md-12">
								<div class="col-md-6">
								<span id="ajax_all_quantity">0 product</span>
								</div>
								<div class="col-md-6 text-right">
								Total : <span id="ajax_all_price">0</span> €
								</div>
								<br/>

								<hr/>

								<form style="max-height: 300px;overflow: scroll;border: 1px solid #ddd;" role="form" id="ajax_display_cart_content">
														<!--<div class="col-md-12">
										<div class="col-md-4">
											<img src="illu/13.jpg" class="img-responsive">
										</div>
										<div class="col-md-5 description-achat">
											<br/>

											<p><strong>Geometric illusion</strong></p>

											<p>
												<small>From Geo Trouvetout</small>
											</p>
											<p>
												<small>Quantity: 2</small>
											</p>
											<p>
												<small>Quantity: 2</small>
											</p>
										</div>
										<div class="col-md-3">
											<br/>
											<br/>

											<p class="price">9$</p>
										</div>
									</div>-->
								</form>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger"><a href="#">Buy it</a></button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->


		<!-- CONTACT -->
		<div class="modal" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="modal-contact-label"
		     aria-hidden="true" style="padding-top: 100px;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center" id="modal-contact-label">CONTACT</h4>
					</div>
					<div class="modal-body">
						<div class="row center-block">
							<div class="col-md-12 text-center">
								<br/>
								<img src="img/contact_mail-01.png" class="img-responsive center-block">
								<br/>

								<p>A problem? A question ? Please send us a message</p>

								<hr>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div class="col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Your Name *" id="name"
										       required data-validation-required-message="Please enter your name.">

										<p class="help-block text-danger"></p>
									</div>
									<div class="form-group">
										<input type="email" class="form-control" placeholder="Your Email *" id="email"
										       required
										       data-validation-required-message="Please enter your email address.">

										<p class="help-block text-danger"></p>
									</div>
									<div class="form-group">
										<input type="tel" class="form-control" placeholder="Your Phone *" id="phone"
										       required
										       data-validation-required-message="Please enter your phone number.">

										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-7 col-lg-7">
									<div class="form-group">
										<textarea class="form-control" placeholder="Your Message *" id="message"
										          required
										          data-validation-required-message="Please enter a message."></textarea>

										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-12 text-center">
									<div id="success"></div>
									<button type="submit" class="btn btn-xl">Send Message</button>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->


	</div>
	<!-- /container -->


	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
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
	<script>
		function traiterFlux(flux) {
			var obj = jQuery.parseJSON(flux);

			var html = " ";
			for (var key in obj) {
				html += '<div class="col-sm-6 col-md-4 col-xs-6 col-lg-3">';
				html += '<div class="thumbnail">';
				html += '<a href="index.php?module=fiche&product=' + obj[key].product_id + '" class="product-image">';
				html += '<img src="' + obj[key].product_img_url + '" class="img-responsive"></a>';
				html += '<div class="caption"><h4>' + obj[key].product_name + '</h4>';
				html += '<p><small><em>By ' + obj[key].user_username + '</em></small></p>';
				html += '<div class="btn-group " style="float: left">';
				html += '<button type="button" class="btn btn-xs btn-default"><i class="fa fa-search"></i></button>';
				html += '<a href="index.php?module=panier&action=addToCart&product=' + obj[key].product_id + '&name=' + obj[key].product_name + '&img_url=' + obj[key].product_img_url + '&from=' + obj[key].user_username + '" class="btn btn-xs btn-default ajax_cart_trigger add-to-cart"><i class="fa fa-shopping-cart"></i></a>';
				html += '</div><div class="text-right">';
				if (obj[key].did_i_like == true) {
					html += '<button type="button" data-product="' + obj[key].product_id + '" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="1">';
					html += '<span class="nb_like" id="nb_like' + obj[key].product_id + '">' + obj[key].nb_like + '</span> ';
					html += '<i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart" style="color: tomato"></i></button>';
				}
				else if (obj[key].did_i_like == false) {
					html += '<button type="button" data-product="' + obj[key].product_id + '" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="0"><span class="nb_like" id="nb_like' + obj[key].product_id + '">' + obj[key].nb_like + '</span> <i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart-o" style="color: tomato"></i></button>';
				}
				else {
					html += '<button type="button" data-product="' + obj[key].product_id + '" class="btn btn-xs btn-default like"><span class="nb_like" id="nb_like' + obj[key].product_id + '">' + obj[key].nb_like + '</span> <i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart-o" style="color: tomato"></i></button>';
				}
				html += '</div></div></div></div>';
			}
			$('#display_load_more').append(html);

		}
		function traiterFlux2(flux) {
			var html = '';
			var all_quantity = 0;
			var all_price = 0;
			for (var key in flux) {
				if (flux[key].size == 's') {
					var price = 5 ;
				} else if (flux[key].size == 'm') {
					var price = 10 ;
				} else if (flux[key].size == 'l') {
					var price = 15 ;
				}
				html += '<div id="product' + key + '" class="col-md-12 ajax_row">';
					html += '<div class="col-md-3">';
						html += '<img src="' + flux[key].img_url + '" class="img-responsive">';
					html += '</div>';
					html += '<div class="col-md-6 description-achat">';
						html += '<br/>';
						html += '<p><strong>' + flux[key].name + '</strong></p>';

						html += '<p>';
						html += '<small>From ' + flux[key].from + '</small>';
						html += '</p>';
						html += '<p>';
						html += '<small>Quantity: <span class="ajax_quantity_display' + key + '">' + flux[key].quantity + '</span> <a href="index.php?module=panier&action=changeQuantity&move=less&product=' + key + '" class="ajax_quantity_trigger" data-id="' + key + '"><i class="fa fa-minus-square"></i></a> <a href="index.php?module=panier&action=changeQuantity&move=more&product=' + key + '" class="ajax_quantity_trigger" data-id="' + key + '"><i class="fa fa-plus-square"></i></a></small>';
						html += '</p>';
						html += '<p>';
						html += '<small><span class="size_title">Size: </span><span data-id="' + key + '" data-size="s" class="size_s' + key + ' size_cart';
						if (flux[key].size == 's') {
							html += ' size_cart_select';
						} else {
							html += ' ajax_size_trigger';
						}
						html +='">s</span> <span data-id="' + key + '" data-size="m" class="size_m' + key + ' size_cart';
						if (flux[key].size == 'm') {
							html += ' size_cart_select';
						} else {
							html += ' ajax_size_trigger';
						}
						html+= '">m</span> <span data-id="' + key + '" data-size="l" class="size_l' + key + ' size_cart';
						if (flux[key].size == 'l') {
							html += ' size_cart_select';
						} else {
							html += ' ajax_size_trigger';
						}
						html+='">l</span></small>';
						html += '</p>';
					html += '</div>';
					html += '<div class="col-md-2">';
						html += '<br/>';
						html += '<br/>';

						html += '<p class="price">' + price + '$</p>';
					html += '</div>';
					html += '<br/>';
					html += '<br/>';
					html += '<div class="col-md-1">';
						html += '<a href="index.php?module=panier&action=deleteFromCart&product=' + key + '" class="ajax_delete_trigger"><i class="fa fa-trash-o"></i></a>'
				    html += '</div>';
			    html += '</div>';

				all_quantity += flux[key].quantity;
				all_price += flux[key].quantity * 10 ;
			}
			if(all_quantity > 1) {
				all_quantity += ' products';
			} else {
				all_quantity += ' product';
			}

			$('#ajax_display_cart_content').html(html);
			$('#ajax_all_quantity').text(all_quantity);
			$('#ajax_all_price').text(all_price);

		}

		$(document).ready(function () {
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});
			$("#load_more").on("click", function (e) {
				e.preventDefault();
				$(this).append('<img id="ajax_loader" src="img/ajax-loader.gif" alt="ajax loader"/>');
				var page = $(this).attr("data-num");
				page++;
				$(this).attr("data-num", page);
				$.ajax({
					// URL du traitement sur le serveur
					url: 'index.php?module=index',
					//Type de requête
					type: 'post',
					//parametres envoyés
					data: 'action=ajax_more&page=' + page,
					//on precise le type de flux
					//Traitement en cas de succes
					success: function (data) {
						if (data == 'no more') {
							$('#load_more').html('no more product');
						}
						else {
							traiterFlux(data);
						}
						$('#ajax_loader').remove();
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus + " " + errorThrown);
						console.log("Erreur execution requete ajax");
					}
				});
			});
			$('#ajax_display_cart').on('click', function(e) {
				//e.preventDefault();
				var url_ajax = $(this).attr("data-ajax");
				$.get(url_ajax, {}, function(data){
					traiterFlux2(data);
				}, 'json');
				//return false;
			});




		});
		$(document).on('click', '.ajax_like_trigger', function () {
			if ($(this).attr("data-didilike") == 1) {
				var product = $(this).attr("data-product");
				var nb_like = $(this).find(".nb_like").html();

				nb_like--;
				$.ajax({
					// URL du traitement sur le serveur
					url: 'index.php?module=index',
					//Type de requête
					type: 'post',
					//parametres envoyés
					data: 'action=ajax_unlike_product&product=' + product,
					//on precise le type de flux
					//Traitement en cas de succes
					success: function (data) {

					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus + " " + errorThrown);
						console.log("Erreur execution requete ajax");
					}
				});
				$(this).find(".nb_like").html(nb_like++);
				$(this).find("i").removeClass("fa-heart");
				$(this).find("i").addClass("fa-heart-o");

				$(this).attr("data-didilike", "0");
			}
			else {

				var product = $(this).attr("data-product");
				var nb_like = $(this).find(".nb_like").html();

				nb_like++;

				$.ajax({
					// URL du traitement sur le serveur
					url: 'index.php?module=index',
					//Type de requête
					type: 'post',
					//parametres envoyés
					data: 'action=ajax_like_product&product=' + product,
					//on precise le type de flux
					//Traitement en cas de succes
					success: function (data) {

					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus + " " + errorThrown);
						console.log("Erreur execution requete ajax");
					}
				});
				$(this).find(".nb_like").html(nb_like++);
				$(this).find("i").removeClass("fa-heart-o");
				$(this).find("i").addClass("fa-heart");
				$(this).attr("data-didilike", "1");
			}
		});
		$(document).on('click', '.ajax_cart_trigger', function (e) {
			e.preventDefault();
			$.get($(this).attr('href'),{},function(data){
				if(data.error){
					alert(data.message);
				}else{
					//SI C BON
					var nb_product = $('#nb_product_ajax').text();
					nb_product ++ ;
					$('#nb_product_ajax').text(nb_product);
				}
			},'json');
			return false;

		});
		$(document).on('click', '.ajax_delete_trigger', function (e) {
			e.preventDefault();
			var idAjax = "#" + $(this).parent().parent("div").attr("id");
			$.get($(this).attr('href'),{},function(data){
				$(idAjax).fadeOut("500");
			},'json');
			return false;
		});
		$(document).on('click', '.ajax_size_trigger', function (e) {
			e.preventDefault();
			var size = $(this).attr("data-size");
			var product = $(this).attr("data-id");
			var urlAjax = 'index.php?module=panier&action=changeSize&size=' + size + '&product=' + product ;
			$.get(urlAjax,{},function(data){
				if (size == 's') {
					var classDislplay = '.size_s' + product;
				} else if (size == 'm') {
					var classDislplay = '.size_m' + product;
				} else if (size == 'l') {
					var classDislplay = '.size_l' + product;
				}
				$(classDislplay).siblings(".size_cart").addClass("ajax_size_trigger");
				$(classDislplay).siblings(".size_cart").removeClass("size_cart_select");

				$(classDislplay).addClass("size_cart_select");
				$(classDislplay).removeClass("ajax_size_trigger");
				if (size == 's') {
					var price = 5 ;
				} else if (size == 'm') {
					var price = 10 ;
				} else if (size == 'l') {
					var price = 15 ;
				}
				$(classDislplay).parent().parent().parent().next().find(".price").text(price + "€");
			},'json');
			return false;
		});
		$(document).on('click', '.ajax_quantity_trigger', function (e) {
			e.preventDefault();
			var product = $(this).attr('data-id');
			$.get($(this).attr('href'),{},function(data){
				var anchor = '.ajax_quantity_display' + product;
				var quantity = $(anchor).text();
				var allQuantity = $('#nb_product_ajax').text();
				if(data.message == 'more'){

					quantity ++;
					allQuantity ++;

				} else if (data.message == 'less'){

					quantity --;
					if (quantity == 0) {
						$(anchor).parent().parent().parent().parent(".ajax_row").fadeOut("500");

					}
					allQuantity --;

				}
				$(anchor).html(quantity)
				$('#nb_product_ajax').text(allQuantity);
				$('#ajax_all_quantity').text(allQuantity + ' products');
			},'json');
			return false;
		});

	</script>
	<script type="text/javascript">

		$(document).on('click', '.add-to-cart', function () {
		var cart = $('.fa-shopping-cart');
		var imgtofly = $(this).parents('div.thumbnail').find('a.product-image img').eq(0);
		if (imgtofly) {
			var imgclone = imgtofly.clone()
				.offset({ top:imgtofly.offset().top, left:imgtofly.offset().left })
				.css({'opacity':'0.7', 'position':'absolute', 'height':'150px', 'width':'150px', 'z-index':'1000'})
				.appendTo($('body'))
				.animate({
					'top':cart.offset().top + 10,
					'left':cart.offset().left + 30,
					'width':55,
					'height':55
				}, 500, 'swing');
			imgclone.animate({'width':0, 'height':0}, function(){ $(this).detach() });
		}
	});
	</script>
<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>