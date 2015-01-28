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
								<a href="index.php?module=signup" class="new-signup">New on Crafters ? Sign up</a>
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