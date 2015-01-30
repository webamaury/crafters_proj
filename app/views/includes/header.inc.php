<div class="container">

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <h1><a href="index.php">CR<span class="logo-mini">a</span>FTERS</a></h1>
            <h2>Tattoos and Stickers designers</h2>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="col-xs-12">
                <div class="col-xs-2 pull-right text-right">
                    <br>
                    <?php
                    if(isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true){
                        ?>
                        <div class="dropdown dropdown_user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION[_SES_NAME]['username']; ?><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="text-right"><a href="index.php?module=profil&user=<?php echo $_SESSION[_SES_NAME]["id"]; ?>">Profil <i class="fa fa-user bs-example-modal-sm"></i></a></li>
                                <li class="text-right"><a href="index.php?module=setting">Settings <i class="fa fa-cog"></i></a></li>
                                <li class="text-right"><a href="index.php?action=logout">Logout <i class="fa fa-power-off bs-example-modal-sm"></i></a></li>
                            </ul>
                        </div>
                          <!--<span class="badge" data-toggle="modal" data-target="#login" style="background-color: darkred;">1</span>-->
                    <?php
                    } else {
                        ?>
                        <a href="#" data-toggle="modal" data-target="#modal-login">Login <i class="fa fa-user"></i></a>
                    <?php
                    }
                    ?>
                </div>
                <?php
                if (!isset($_GET['module']) || $_GET['module'] != 'commande') {
                ?>
                    <div class="col-xs-2 pull-right text-right">
                        <br>
                        <a href="#" data-ajax="index.php?module=panier&action=displayCart" class="ajax_display_cart" data-toggle="modal" data-target="#modal-shoppingbag">
                            <i class="fa fa-shopping-cart"></i>
                        <span class="badge" style="background-color: white; color: black;">
                        (<span class="nb_product_ajax"><?php
                                if(isset($_SESSION[_SES_NAME]['Cart'])){
                                    $nb_prod = 0;
                                    foreach ($_SESSION[_SES_NAME]['Cart'] as $obj) {
                                        $nb_prod += $obj['quantity'];

                                    }
                                    echo $nb_prod;
                                } else {
                                    echo 0;
                                }

                                ?></span>)</span>
                        </a>
                    </div>
                <?php
                }
                ?>

            </div>
            <div class="col-xs-12">
                <br>
                <ul class="nav nav-pills col-md-offset-3">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php?module=gallery">Gallery</a></li>
                    <!--<li><a href="#">Monthly Set</a></li>-->
                    <li><a href="contact.php" data-toggle="modal" data-target="#modal-contact">Contact</a> </li>
                    <?php
                    if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
                    ?>
                    <li><a href="index.php?module=upload" class="btn upload-2 upload-2c star upload_header">Upload</a>
                    <?php
                    } else {
                    ?>
                    <li><a href="#" data-toggle="modal"data-target="#modal-login" class="btn upload-2 upload-2c star upload_header">Upload</a>
                    <?php
                    }
                    ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <hr>
    </div>
    <br>