<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>

	<!--Content-->
	<div class="row content">
		<div class="container">

			<div class="row">
				<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>
			</div>

			<div class="col-sm-5 col-xs-12 pull-right">
				<form action="index.php" method="get" class="navbar-form navbar-right" role="search">
					<div class="input-group input-group-sm">
						<input type="hidden" name="module" value="gallery">
						<input type="text" name="search" pattern=".{3,20}" required title="3 to 20 characters" class="form-control searchval" value="<?php echo (isset($_GET['search'])) ? $_GET['search'] : "" ; ?>" placeholder="Search for...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
					</div>
				</form>
			</div>
			<div class="col-xs-12 col-sm-7">
				<ol class="breadcrumb">
					<li> <a href="index.php?module=gallery">Newest</a></li>
					<li> <a href="index.php?module=gallery&order=popular">Popular</a></li>
				</ol>
			</div>

			<div class="col-sm-12">


				<div id="display_load_more" class="row">
					<span data-order="<?php echo (isset($_GET['order'])) ? $_GET['order'] : 'newest' ; ?>" class="orderby"></span>
					<?php
					foreach ($products as $product) {
						?>
						<div class="col-sm-4 col-md-3 col-xs-6 col-lg-3">
							<div class="thumbnail parent">
								<a href="<?php echo (_REW_URL == 'true') ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>" class="product-image">
									<img src="<?php echo $product->product_img_url; ?>" class="img-responsive prodIMG" alt="Temporary Tattoo <?php echo $product->product_name; ?> | Crafters">
								</a>

								<div class="caption">
									<h4><?php echo $product->product_name; ?></h4>

									<p>
										<small><em>By <?php echo $product->user_username; ?></em></small>
									</p>
									<div class="btn-group " style="float: left">
										<a href="<?php echo (_REW_URL == 'true') ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
										<a href="index.php?module=panier&action=addToCart&product=<?php echo $product->product_id; ?>&img_url=<?php echo $product->product_img_url; ?>&name=<?php echo $product->product_name; ?>&from=<?php echo $product->user_username; ?>" class="btn btn-xs ajax_cart_trigger btn-default add-to-cart"><i class="fa fa-shopping-cart"></i></a>
									</div>
									<div class="text-right"><?php
										if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
											if (isset($product->did_i_like) && $product->did_i_like == true) {
												?>
												<button type="button" data-product="<?php echo $product->product_id; ?>" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="1">
													<span class="nb_like" id="nb_like<?php echo $product->product_id; ?>"><?php echo $product->nb_like; ?></span>
													<i class="fa fa-heart" style="color: tomato"></i>
												</button>
											<?php
											} else {
												?>
												<button type="button" data-product="<?php echo $product->product_id; ?>" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="0">
													<span class="nb_like" id="nb_like<?php echo $product->product_id; ?>"><?php echo $product->nb_like; ?></span>
													<i class="fa fa-heart-o" style="color: tomato"></i>
												</button>
											<?php
											}
										} else {
											?>
											<button data-toggle="modal" data-target="#modal-login" type="button" data-product="<?php echo $product->product_id; ?>" class="btn btn-xs btn-default like">
													<span class="nb_like" id="nb_like<?php echo $product->product_id; ?>"><?php echo $product->nb_like; ?></span>
													<i class="fa fa-heart-o" style="color: tomato"></i>
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
	<!--/Content-->

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>