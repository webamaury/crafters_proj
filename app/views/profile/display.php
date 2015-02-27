<?php include("../app/views/includes/head.inc.php") ; ?>

<?php include("../app/views/includes/header.inc.php"); ?>

	<!--Content-->
	<div class="row content">
		<div class="container">

			<div class="row">
				<?php echo $notices->displayNotice(true); ?>
			</div>

			<div class="row dashboard_infos">
				<div class="col-xs-12 col-sm-8 col-sm-offset-1">
					<div class="col-sm-6 col-sm-offset-4 col-xs-8 col-xs-offset-2 col-md-3 col-md-offset-1 text-center">
						<div id="output">
							<img src="<?php echo (isset($user->user_img_url) && file_exists($user->user_img_url)) ? _PATH_FOLDER . $user->user_img_url : _PATH_FOLDER . "img/default/defaultprod.png" ;?>" class="img-circle img-responsive" style="float:right;">
						</div>
						<?php
						if ($myprofile == true) {
							?>
							<form action="index.php?module=profile" method="post" id="form_ajax" enctype="multipart/form-data">
								<small><i class="fa fa-edit"></i> <a href="#" id="btn_ajax"> Modify </a></small>
								<input type="file" name="image_file" id="js-upload-files" class="hideinput"/>
								<input type="hidden" name="action" value="upload_ajax"/>
							</form>
							<form action="index.php?module=profile" method="post" class="hideform" id="form_url_ajax">
								<small><i class="fa fa-edit"></i> <a href="#" id="btn_url_ajax"> Validate </a></small>
								<input type="hidden" name="img_url" id="img_url"/>
								<input type="hidden" name="action" value="update_img_url_ajax"/>
							</form>
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
								<a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">My Orders</a>
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
							<div id="display_load_more">
								<?php
								foreach ($products as $product) {
									?>
									<div class="col-sm-4 col-md-3 col-xs-6 col-lg-3">
										<div class="thumbnail parent">
											<a href="<?php echo (_REW_URL == 'true') ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>" class="product-image"><img src="<?php echo _PATH_FOLDER . $product->product_img_url; ?>" class="img-responsive prodIMG"></a>

											<div class="caption">
												<h4><?php echo $product->product_name; ?></h4>

												<p>
													<small><em>By <?php echo $user->user_username; ?></em></small>
												</p>
												<div class="btn-group " style="float: left">
													<a href="<?php echo (_REW_URL == 'true') ? "/product=>" . $product->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $product->product_id ; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
													<?php
													if ($myprofile == true && 1 == 2) {
														?>
														<a href="#" data-href="index.php?module=profile&action=deleteCraft&product=<?php echo $product->product_id; ?>" data-toggle="modal" data-target=".modal_supprod" class="btn btn-xs btn-default modal_supp_trigger">
															<i class="fa fa-trash-o"></i>
														</a>
													<?php
													}
													?>
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
																<i class="fa fa-heart" style="color: tomato"></i>
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
																<i class="fa fa-heart-o" style="color: tomato"></i>
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
							<?php
							if (count($products) == 8) {
							?>
								<div class="col-xs-12">
									<div class="btn-group btn-group-justified" role="group" aria-label="...">
										<div class="btn-group" role="group">
											<a href="#" id="load_more_profile" data-num="1"
											   data-user="<?php echo (isset($user->user_id)) ? $user->user_id : ""; ?>"
											   class="btn btn-default">load more...</a>
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
														<td>Order <?php echo $order->order_hash; ?> - <?php if($order->order_status == 0) { echo "waiting for payment"; } else if ($order->order_status == 1) { echo "In progress"; } else { echo "Send"; } ; ?></td>
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
											<div class="col-xs-9 col-sm-5">
												<input type="text" maxlength="30" name="username" class="form-control" id="username" value="<?php echo (isset($user->user_username)) ? $user->user_username : '' ; ?>" required>
											</div>
											<br/><br/>
										</div>
										<div class="form-group">
											<label for="firstname" class="col-xs-2 col-sm-4 control-label">Firstname</label>
											<div class="col-xs-9 col-sm-5">
												<input type="text" maxlength="20" name="firstname" class="form-control" id="firstname" value="<?php echo (isset($user->user_firstname)) ? $user->user_firstname : '' ; ?>" required>
											</div>
											<br/><br/>
										</div>
										<div class="form-group">
											<label for="name" class="col-xs-2 col-sm-4 control-label">Name</label>
											<div class="col-xs-9 col-sm-5">
												<input type="text" maxlength="30" name="name" class="form-control" id="name" value="<?php echo (isset($user->user_name)) ? $user->user_name : '' ; ?>" required>
											</div>
											<br/><br/>
										</div>
										<div class="form-group">
											<label for="mail" class="col-xs-2 col-sm-4 control-label">Mail</label>
											<div class="col-xs-9 col-sm-5">
												<input type="email" maxlength="100" name="mail" class="form-control" id="mail" value="<?php echo (isset($user->user_mail)) ? $user->user_mail : '' ; ?>" required>
											</div>
											<div class="col-xs-1 questionprofile">
												<i data-toggle="tooltip" data-container="body" data-placement="right" title="Your mail won't change immediately. You will receive an e-mail on your new address to confirm it before this change happen." class="fa fa-info-circle"></i>
											</div>

											<br/><br/>
										</div>
										<div class="form-group">
											<label for="phone" class="col-xs-2 col-sm-4 control-label">Phone</label>
											<div class="col-xs-9 col-sm-5">
												<input type="tel" name="phone" class="form-control" id="phone" value="<?php echo (isset($user->user_phone)) ? $user->user_phone : '' ; ?>">
											</div>
											<br/><br/>
										</div>
										<div class="form-group">
											<label for="birthday" class="col-xs-2 col-sm-4 control-label">Birthday</label>
											<div class="col-xs-9 col-sm-5">
												<input type="date" name="birthday" class="form-control" id="birthday" value="<?php echo (isset($user->user_birthday)) ? $user->user_birthday : '' ; ?>">
											</div>
											<br/><br/>
										</div>
										<div class="form-group">
											<label for="birthday" class="col-xs-2 col-sm-4 control-label">Password</label>
											<div class="col-xs-9 col-sm-5">
												<button type="button" data-toggle="modal" data-target=".modal-update-password" class="btn btn-default btn-block">Change password</button>
											</div>
											<br/><br/>
										</div>								</div>
									<div class="col-xs-10 margin-top-20">
										<input type="hidden" name="action" value="update">
										<button type="submit" class="btn btn-danger pull-right">Update</button>
									</div>
								</form>
							</div>
							<?php
							include_once(_APP_PATH . 'views/includes/modal_password.inc.php');
						}
						?>
					</div>

				</div>

			</div>

		</div>
	</div>
	<!--/Content-->

	<?php include_once(_APP_PATH . 'views/includes/modal_supprod.inc.php'); ?>

	<script type="text/javascript" src="js/addavatar.js"></script>


<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>