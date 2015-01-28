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