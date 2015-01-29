<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

	<!-- container -->
<div class="container">

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>


	<div class="field" id="searchform">
		<input type="text" id="searchterm" placeholder="What are you searching for?">
		<button type="button" id="search">Get it !</button>
	</div>
	<div class="container">
		<div class="container big-gallery">
			<div class="col-sm-5 col-md-5">

				<ol class="breadcrumb">
					<li class="active"><a href="#">Tattoo</a></li>
					<li> <a href="#">Stickers</a></li>
					<li> <a href="#">Popular</a></li>
					<li> <a href="#">Newest</a></li>
					<li> <a href="#">All</a></li>
				</ol>
			</div>


			<div class="col-sm-12">


				<div id="display_load_more" class="row">

					<?php
					foreach ($products as $product) {
						?>
						<div class="col-sm-4 col-md-3 col-xs-6 col-lg-3">
							<div class="thumbnail">
								<a href="index.php?module=fiche&product=<?php echo $product->product_id; ?>" class="product-image"><img src="<?php echo $product->product_img_url; ?>" class="img-responsive"></a>

								<div class="caption">
									<h4><?php echo $product->product_name; ?></h4>

									<p>
										<small><em>By <?php echo $product->user_username; ?></em></small>
									</p>
									<div class="btn-group " style="float: left">
										<a href="index.php?module=fiche&product=<?php echo $product->product_id; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
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
						<a href="#" id="load_more" data-num="1" class="btn btn-default">load more...</a>
					</div>
				</div>



			</div>
		</div>
	</div>
</div>
<!-- /container -->

<script type="text/javascript" src="tools/jQuery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="tools/bootstrap-3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="tools/jQueryUI-1.11.1/jquery-ui.min.js"></script>
	<script>
		$(function() {
			$( "#searchterm" ).autocomplete({
				source: "index.php?module=gallery&action=searchAutocomplete"
			});
		});
	</script>
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