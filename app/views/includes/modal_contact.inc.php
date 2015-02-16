<!-- CONTACT -->
<div class="modal" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="modal-contact-label" aria-hidden="true" style="padding-top: 100px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-center" id="modal-contact-label">CONTACT</h4>
			</div>
			<div class="modal-body">
				<div class="row center-block">
					<div class="col-md-12 text-center">
						<i class="fa fa-envelope-o contact_envelope"></i>
						<br/>

						<p>A problem? A question ? Please send us a message</p><br>
					</div>
				</div>
				<div class="row">
					<form action="index.php" method="post">
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div class="col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1">
									<div class="form-group">
										<input type="text" class="form-control" name="firstname" value="<?php echo (isset($_SESSION[_SES_NAME]['firstname'])) ? $_SESSION[_SES_NAME]['firstname'] : "" ; ?>" placeholder="Your Name *" id="name" required>
										<p class="help-block text-danger"></p>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="name" value="<?php echo (isset($_SESSION[_SES_NAME]['name'])) ? $_SESSION[_SES_NAME]['name'] : "" ; ?>" placeholder="Your Email *" id="email" required>
										<p class="help-block text-danger"></p>
									</div>
									<div class="form-group">
										<input type="email" class="form-control" name="mail" value="<?php echo (isset($_SESSION[_SES_NAME]['mail'])) ? $_SESSION[_SES_NAME]['mail'] : "" ; ?>" placeholder="Your Phone" id="phone">
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-7 col-lg-7">
									<div class="form-group">
										<textarea class="form-control" rows="6" name="message" maxlength="600" placeholder="Your Message *" id="message" required></textarea>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-12 text-center">
									<div id="success"></div>
									<input type="hidden" name="action" value="contact">
									<button type="submit" class="btn btn-large btn-danger">Send Message</button>
								</div>
								<br><br>
							</div>
						</div>
					</form>
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