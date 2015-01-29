<?php include(_APP_PATH . "views/includes/head.inc.php"); ?>

<div class="container">

	<?php include(_APP_PATH . "views/includes/header.inc.php"); ?>


	<div class="container">				

		<form class="form-horizontal" method="post" action="index.php?module=signup" role="form">
			<fieldset>
			
			<!-- Form Name -->
			<legend id="legend">Register</legend>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Name">Name</label>  
			  <div class="col-md-4">
			  <input id="Name" name="name" type="text" placeholder="John" class="form-control input-md" required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Firstname">Firstname</label>  
			  <div class="col-md-4">
			  <input id="Firstname" name="firstname" type="text" placeholder="Doe" class="form-control input-md"required>
			    
			  </div>
			</div>
			
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Username">Username</label>  
			  <div class="col-md-4">
			  <input id="Username" name="username" type="text" placeholder="JDoe" class="form-control input-md"required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Mail">Mail</label>  
			  <div class="col-md-5">
			  <input id="Mail" name="mail" type="text" placeholder="johndoe@gmail.com" class="form-control input-md"required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Password">Password</label>  
			  <div class="col-md-4">
			  <input id="Password" name="password" type="password" placeholder="" class="form-control input-md"required>
			    
			  </div>
			</div>
			
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="Confirm password">Confirm password</label>  
			  <div class="col-md-4">
			  <input id="Confirm password" name="Confirm password" type="password" placeholder="" class="form-control input-md">
			    
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