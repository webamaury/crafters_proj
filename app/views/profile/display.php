<?php include("../app/views/includes/head.inc.php") ; ?>

<div class="container">

<?php include("../app/views/includes/header.inc.php"); ?>

	<div class="container">
		<?php echo $notices->displayNotice(true); ?>

		<?php
		//var_dump($user, $products, $orders);
		?>

		<div class="row dashboard_infos">
			<div class="col-xs-12 col-sm-8 col-sm-offset-1">
				<div class="col-sm-6 col-sm-offset-4 col-xs-8 col-xs-offset-2 col-md-3 col-md-offset-1 text-center">
					<img src="<?php echo (isset($user->user_img_url) && file_exists($user->user_img_url)) ? $user->user_img_url : "img/default/defaultprod.png" ;?>" class="img-circle img-responsive" style="float:right;">
					<?php
					if ($myprofile == true) {
						?>
						<small><i class="fa fa-edit"></i> <a href="#"> Modify </a></small>
						<?php
					}
					?>
					<br>

				</div>
				<div class="col-xs-12 col-md-7 col-md-offset-1">
					<h3 class="dashboard_name"><?php  echo (isset($user->user_username)) ? $user->user_username : "" ; ?> (<?php  echo (isset($user->user_firstname) && isset($user->user_firstname)) ? $user->user_firstname . " " . $user->user_name : "" ; ?>)</h3>
					<p class="profileInfos">
						<?php  echo (isset($user->DateBirth) && !empty($user->DateBirth)) ? "Birthday: " . $user->DateBirth . "<br><br>" : "" ; ?>
						<?php  echo (isset($user->user_mail) && !empty($user->user_mail)) ? "Mail: " . $user->user_mail . "<br>" : "" ; ?>
						<?php  echo (isset($user->user_phone) && !empty($user->user_phone)) ? "Phone: " . $user->user_phone . "<br>" : "" ; ?>

					</p>
					<!--<small><i class="fa fa-folder"></i> 12 crafts</small> <br/>
					<small><i class="fa fa-users"></i> 345 followers</small>-->
					<br/>
				</div>
			</div>
			<div class="col-md-12">
				<br>
				<hr>
			</div>

		</div>
		<div class="row">
			<?php
			if ($myprofile == true) {
				?>
				<div class="col-xs-12 text-center">

					<ul class="list-inline dashboard_navigation">
						<li role="presentation"<?php echo (!isset($_GET['where']) || $myprofile != true) ? ' class="active"' : ""; ?>>
							<a href="#uploads" aria-controls="uploads" role="tab" data-toggle="tab">My Uploads</a>
							&nbsp;&nbsp;&nbsp;|
						</li>
						<li role="presentation"<?php echo (isset($_GET['where']) && $_GET['where'] == 'orders') ? ' class="active"' : ""; ?>>
							<a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">My Oders</a>
							&nbsp;&nbsp;&nbsp;|
						</li>
						<li role="presentation"<?php echo (isset($_GET['where']) && $_GET['where'] == 'infos') ? ' class="active"' : ""; ?>>
							<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">My Infos</a>
							&nbsp;&nbsp;
						</li>
					</ul>
				</div>
				<?php
			}
			?>
		</div>
		<div class="row">
			<div role="tabpanel">

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane<?php echo (!isset($_GET['where']) || $myprofile != true) ? " active" : ""; ?>" id="uploads">
						<br/>
						<?php
						foreach ($products as $product) {
							?>
							<div class="col-sm-4 col-md-3 col-xs-6 col-lg-3">
								<div class="thumbnail">
									<a href="index.php?module=fiche&product=<?php echo $product->product_id; ?>" class="product-image"><img src="<?php echo $product->product_img_url; ?>" class="img-responsive"></a>

									<div class="caption">
										<h4><?php echo $product->product_name; ?></h4>

										<p>
											<small><em>By <?php echo $user->user_username; ?></em></small>
										</p>
										<div class="btn-group " style="float: left">
											<a href="index.php?module=fiche&product=<?php echo $product->product_id; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
											<a href="index.php?module=panier&action=addToCart&product=<?php echo $product->product_id; ?>&img_url=<?php echo $product->product_img_url; ?>&name=<?php echo $product->product_name; ?>&from=<?php echo $user->user_username; ?>" class="btn btn-xs ajax_cart_trigger btn-default add-to-cart"><i class="fa fa-shopping-cart"></i></a>
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
					<?php
					if ($myprofile == true) {
						?>
						<div role="tabpanel" class="tab-pane<?php echo (isset($_GET['where']) && $_GET['where'] == 'orders') ? " active" : ""; ?>" id="orders">
							<br/>
							<br/>
							<?php
							//var_dump($orders);
							?>
							<div class="col-xs-12">
								<div class="col-xs-12 ">
									<div class="panel panel-default">
										<!-- Default panel contents -->
										<div class="panel-heading"><span class="order_title">Your orders</span></div>
										<!-- Table -->
										<table class="table table-responsive">
											<?php
											foreach ($orders as $order) {
											?>
												<tr>
													<td>Order <?php echo $order->order_hash; ?> - <?php if($order->order_status == 0) { echo "waiting for payment"; } else if ($order->order_status == 1) { echo "In progess"; } else { echo "Send"; } ; ?></td>
													<td><?php echo ($order->order_delivery == 0) ? "Normal" : "Express"; ?></td>
													<td><?php echo $order->order_creation; ?></td>
													<td><?php echo ($order->order_payment_mode == 0) ? "Paypal" : "Check" ; ?></td>
													<td><?php echo number_format($order->order_price,2,","," "); ?> €</td>
												</tr>
											<?php
											}
											?>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane<?php echo (isset($_GET['where']) && $_GET['where'] == 'infos') ? " active" : ""; ?>" id="profile"><br>
							<form class="form-horizontal" method="post" action="index.php?module=profile" role="form">
								<div class="col-xs-12">
									<div class="form-group">
										<label for="username" class="col-xs-2 col-sm-4 control-label">Username</label>
										<div class="col-xs-10 col-sm-6">
											<input type="text" maxlength="30" name="username" class="form-control" id="username" value="<?php echo (isset($user->user_username)) ? $user->user_username : '' ; ?>" required>
										</div>
										<br/><br/>
									</div>
									<div class="form-group">
										<label for="firstname" class="col-xs-2 col-sm-4 control-label">Firstname</label>
										<div class="col-xs-10 col-sm-6">
											<input type="text" maxlength="20" name="firstname" class="form-control" id="firstname" value="<?php echo (isset($user->user_firstname)) ? $user->user_firstname : '' ; ?>" required>
										</div>
										<br/><br/>
									</div>
									<div class="form-group">
										<label for="name" class="col-xs-2 col-sm-4 control-label">Name</label>
										<div class="col-xs-10 col-sm-6">
											<input type="text" maxlength="30" name="name" class="form-control" id="name" value="<?php echo (isset($user->user_name)) ? $user->user_name : '' ; ?>" required>
										</div>
										<br/><br/>
									</div>
									<div class="form-group">
										<label for="mail" class="col-xs-2 col-sm-4 control-label">Mail</label>
										<div class="col-xs-10 col-sm-6">
											<input type="email" maxlength="100" name="mail" class="form-control" id="mail" value="<?php echo (isset($user->user_mail)) ? $user->user_mail : '' ; ?>" required>
										</div>
										<br/><br/>
									</div>
									<div class="form-group">
										<label for="phone" class="col-xs-2 col-sm-4 control-label">Phone</label>
										<div class="col-xs-10 col-sm-6">
											<input type="tel" name="phone" class="form-control" id="phone" value="<?php echo (isset($user->user_phone)) ? $user->user_phone : '' ; ?>">
										</div>
										<br/><br/>
									</div>
									<div class="form-group">
										<label for="birthday" class="col-xs-2 col-sm-4 control-label">Birthday</label>
										<div class="col-xs-10 col-sm-6">
											<input type="date" name="birthday" class="form-control" id="birthday" value="<?php echo (isset($user->user_birthday)) ? $user->user_birthday : '' ; ?>">
										</div>
										<br/><br/>
									</div>

								</div>
								<div class="col-xs-12 margin-top-20">
									<input type="hidden" name="action" value="update">
									<button type="submit" class="btn btn-danger pull-right">Update</button>
								</div>
							</form>
						</div>
					<?php
					}
					?>
				</div>

			</div>

		</div>
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