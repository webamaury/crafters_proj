
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <h1><a href="index.php">CR<span class="logo-mini">a</span>FTERS</a></h1>
            <h2>Tattoos and Stickers designers</h2>
        </div>
        <div class="col-md-4 col-md-offset-2 col-sm-4 col-xs-6">
            <br/>
            <br/>
            <ul class="nav nav-pills">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gallery<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Tattoos</a></li>
                        <li><a href="#">Stickers</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Most Popular</a></li>
                    </ul>
                </li>
                <li><a onclick="ga('send','event','MonthlySet','Clique');" href="#">Monthly Set</a></li>
                <li><a href="contact.php" data-toggle="modal" data-target="#modal-contact">Contact</a> </li>
            </ul>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-3">
            <br/>
            <br/>
            <a href="#"data-toggle="modal" data-target="#modal-shoppingbag"> <i class="fa fa-shopping-cart"></i> <span class="badge" style="background-color: white; color: black;">(2)</span>
            </a>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-3">
            <br/>
            <br/>
            <?php
			if(isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] == true){
            ?>
            <a href="index.php?action=logout"><i class="fa fa-power-off"></i></a> <span class="badge" data-toggle="modal" data-target="#login" style="background-color: darkred;">1</span>
            <?php
	        }
	        else {
		    ?>
            <a href="#" data-toggle="modal" data-target="#modal-login"><i class="fa fa-user"></i></a> <span class="badge" data-toggle="modal" data-target="#login" style="background-color: darkred;">1</span>
            <?php
	            }
	        ?>
        </div>
    </div>

    <div class="row">
        <hr>
    </div>