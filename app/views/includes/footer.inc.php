			<footer>
				<br/><br/>
				<div class="container text-center">
					<ul class="list-inline">
						<li><a href="<?php echo (_REW_URL == true) ? "/whoweare" : "index.php?module=autre&action=whoweare" ; ?>"><small>Who we are</small></a></li>
						<li>·</li>
						<li><a href="<?php echo (_REW_URL == true) ? "/termsofservice" : "index.php?module=autre&action=terms" ; ?>"><small>Terms of Service</small></a></li>
						<li>·</li>
						<li><a href="<?php echo (_REW_URL == true) ? "/privacy" : "index.php?module=autre&action=privacy" ; ?>"><small>Privacy Policy</small></a></li>
						<li>·</li>
						<li><a href="#" data-toggle="modal" data-target="#modal-contact"><small>Contact</small></a></li>
						<li>·</li>
						<li><small>Crafters &copy; <?php echo date('Y'); ?> All Rights Reserved</small></li>
					</ul>
				</div>
				<br/>
			</footer>



			<?php include( _APP_PATH . 'views/includes/modal_contact.inc.php'); ?>
			<?php include( _APP_PATH . 'views/includes/modal_login.inc.php'); ?>
			<?php include( _APP_PATH . 'views/includes/modal_forgotpwd.inc.php'); ?>
			<?php include( _APP_PATH . 'views/includes/modal_panier.inc.php'); ?>
		</div>

			<?php if(_CNIL == false) { ?>
			<div class="hide_cnil">
				<br/>

				<div class="cnil">
					<div class="container">
						<div class="col-xs-11">
							<p class="text-muted">
								Crafters uses cookies to offer you the best user experience. We won't share them with anybody except as describe in <a href="<?php echo (_REW_URL == true) ? "/privacy" : "index.php?module=autre&action=privacy" ; ?>">Privacy Policy</a>. If you continue, you accept the usage of cookies.
							</p>
						</div>
						<div class="col-xs-1 pull-right text-right">
							<i class="fa fa-times cnil_ajax_trigger"></i>
						</div>
						</p>
					</div>
				</div>
			</div>
			<?php } ?>
		<?php echo $this->load_js($JsToLoad, $arrayJs) ; ?>

		<script type="text/javascript" src="js/allpages.js"></script>
		<script type="text/javascript" src="js/ganalytics.js"></script>

	</body>
</html>