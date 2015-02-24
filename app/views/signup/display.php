<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>

	<!--Content-->
	<div class="row content">

		<div class="container">

		<div class="row">
			<?php echo $notices->displayNotice(); $notices->clearNotice(); ?>	
		</div>

		<form class="form-horizontal" method="post" action="index.php?module=signup" role="form">
			<fieldset>
			
			<!-- Form Name -->
			<legend id="legend">Register</legend>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Name">Name</label>  
			  <div class="col-md-4">
			  <input id="Name" name="name" type="text" placeholder="John" class="form-control input-md"  maxlength="30" required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Firstname">Firstname</label>  
			  <div class="col-md-4">
			  <input id="Firstname" name="firstname" type="text" placeholder="Doe" class="form-control input-md" maxlength="20" required>
			    
			  </div>
			</div>
			
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Username">Username</label>  
			  <div class="col-md-4">
			  <input id="Username" name="username" type="text" placeholder="JDoe" class="form-control input-md" maxlength="15" required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Mail">Mail</label>  
			  <div class="col-md-5">
			  <input id="Mail" name="mail" type="email" placeholder="johndoe@gmail.com" class="form-control input-md" maxlength="100" required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Password">Password</label>  
			  <div class="col-md-4">
			  <input id="Password" name="password" type="password" placeholder="" class="form-control input-md" maxlength="40" required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="ConfirmPassword">Confirm password</label>  
			  <div class="col-md-4">
			  <input id="ConfirmPassword" name="confirmpassword" type="password" placeholder="" class="form-control input-md" maxlength="40" required>
			    
			  </div>
			</div>
			
			<div class="form-group">
			  <label class="col-md-4 control-label" for=""></label>
			  <input type="hidden" name="action" value="signup">
			  <div class="col-md-4-">
			    <button id="" name="" class="btnconfirm">Confirm</button>
			  </div>
			</div>
			
			
			</fieldset>
		</form>

	</div>

	</div>
	<!--/Content-->

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>