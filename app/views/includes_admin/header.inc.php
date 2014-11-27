    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Project name</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Accueil</a></li>
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
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Config</a></li>
                <li><a href="#">settings</a></li>
              </ul>
            </li>
            <?php echo (_DEBUG == true) ? '<li><a href="index.php?module=traces" target="_blank"><span class="glyphicon glyphicon-file"></span> Trace</a></li>' : '' ; ?>
            <li><a href="index.php?module=admin_users&display=fiche&id=<?php echo $_SESSION['ADMIN-USER']['id'] ; ?>"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
            <li><a href="index.php?action=logout"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
            <?php include_once(_APP_PATH . "views/includes_admin/modal_conf.inc.php"); ?>
          </ul>
        </div>
      </div>
    </div>
