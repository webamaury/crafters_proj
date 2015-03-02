    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php echo _SITE_NAME; ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Modules <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                    <?php
                    foreach ($modules as $module)
                    {
                      ?>
                <li><a href="index.php?module=<?php echo $module['path'] ; ?>"><span class="glyphicon <?php echo $module['icon'] ; ?>"></span> <?php echo $module['name'] ; ?></a></li>
                      <?php
                    }
                      ?>
                <li class="divider"></li>
                <li class="dropdown-header">Settings</li>
                <li><a href="index.php?module=adminUsers"><span class="glyphicon glyphicon-star"></span> Admin</a></li>
                <li><a href="index.php?module=config"><span class="glyphicon glyphicon-cog"></span> Config</a></li>
              </ul>
            </li>
            <?php echo (_DEBUG == true) ? '<li><a href="index.php?module=traces" target="_blank"><span class="glyphicon glyphicon-file"></span> Trace</a></li>' : '' ; ?>
            <li>
            	<a href="index.php?module=adminUsers&amp;action=form&amp;id=<?php echo $_SESSION['ADMIN-USER']['id'] ; ?>">
	            	<img class="avatar_header" src="<?php echo (isset($_SESSION["ADMIN-USER"]["img_url"]) && file_exists(_WWW_PATH . $_SESSION["ADMIN-USER"]["img_url"])) ? _WWW_PATH . $_SESSION["ADMIN-USER"]["img_url"] : _ADMIN_PATH . 'img/avatar.jpg'; ?>" alt="avatar"/> <?php echo $_SESSION['ADMIN-USER']['firstname'] ; ?>
	            </a>
	        </li>
            <li><a href="index.php?action=logout"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
            <?php include_once(_APP_PATH . "views/includes_admin/modal_conf.inc.php"); ?>
          </ul>
        </div>
      </div>
    </div>
