
    <div class="row header">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-3 col-xs-6">
                    <h1><a href="<?php echo (_REW_URL == true) ? "/home" : "index.php" ; ?>">CR<span class="logo-mini">a</span>FTERS</a></h1>
                    <h2>Tattoos and Stickers designers</h2>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-6 pull-right">
                    <div class="col-xs-7 pull-right text-right">
                        <div class="row">
                            <br>
                            <?php
                            if(isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true){
                                ?>
                                <div class="dropdown dropdown_user">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION[_SES_NAME]['username']; ?><span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="text-right"><a href="<?php echo (_REW_URL == true) ? "/profile" : "index.php?module=profile" ; ?>">Profile <i class="fa fa-user bs-example-modal-sm"></i></a></li>
                                        <li class="text-right"><a href="<?php echo (_REW_URL == true) ? "/profile=>orders" : "index.php?module=profile&where=orders" ; ?>">My orders <i class="fa fa-cog"></i></a></li>
                                        <li class="text-right"><a href="<?php echo (_REW_URL == true) ? "/profile=>infos" : "index.php?module=profile&where=orders" ; ?>">Settings <i class="fa fa-cog"></i></a></li>
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
                    </div>
                    <?php
                    if (!isset($_GET['module']) || $_GET['module'] != 'commande') {
                        ?>
                        <div class="col-xs-5 pull-right text-right">
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
                <div class="col-lg-5 col-md-6 col-xs-12 menu">
                    <br>
                    <ul class="nav nav-pills">
                        <li><a href="<?php echo (_REW_URL == true) ? "/home" : "index.php" ; ?>">Home</a></li>
                        <li><a href="<?php echo (_REW_URL == true) ? "/gallery" : "index.php?module=gallery" ; ?>">Gallery</a></li>
                        <!--<li><a href="#">Monthly Set</a></li>-->
                        <li><a href="#" data-toggle="modal" data-target="#modal-contact">Contact</a> </li>
                        <?php
                        if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
                        ?>
                        <li><a href="<?php echo (_REW_URL == true) ? "/upload" : "index.php?module=upload" ; ?>" class="btn upload-2 upload-2c star upload_header">Upload</a>
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
    </div>

    <div class="row">
        <hr class="hr_header">
    </div>
    <br>