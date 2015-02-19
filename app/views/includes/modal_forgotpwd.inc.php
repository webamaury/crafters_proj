<div class="modal" id="modal-forgotpwd" tabindex="-1" role="dialog" aria-labelledby="modal-login-label"
     aria-hidden="true" style="padding-top: 100px;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal-forgot-label">Forgot password?</h4>
			</div>
			<form role="form" method="post" action="index.php?module=profile">

				<div class="modal-body">
					<div class="row center-block">
						<div class="col-md-12">

							<h3>Enter your e-mail <i data-toggle="tooltip" data-container="body" data-placement="right" title="You will receive an e-mail to confirm your identity. Click on the link to change your password." class="fa fa-info-circle questionprofile"></i></h3>

								<div class="form-group">
									<input type="email" name="email" placeholder="jdoe@gmail.com" class="form-control" required>
								</div>
								<input type="hidden" name="action" value="forgotpwd"/>

						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn btn-danger pull-right">
						<i class="fa fa-paper-plane"></i> Send
					</button>
				</div>

			</form>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->