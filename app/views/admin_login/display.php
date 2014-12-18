<?php include(_APP_PATH . "views/includes_admin/head.inc.php"); ?>
    <div class="container" role="main">

      <form class="form-signin" action="" method="POST" role="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input name="mail" type="email" class="form-control" placeholder="Email address" required autofocus>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
        <!--<label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>-->
        <input type="hidden" name="action" value="login">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
    <div class="container">
      <?php echo display_notice(); clear_notice(); ?>
    </div>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
