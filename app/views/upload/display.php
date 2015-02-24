<?php include("../app/views/includes/head.inc.php") ; ?>

<?php include("../app/views/includes/header.inc.php"); ?>
		
    <!--Content-->
    <div class="row content">

        <div class="container">

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <h3 style="text-align: right" class="title_upload">UPLOAD YOUR AWESOME WORK</h3>
                <form action="index.php?module=upload" method="post" class="form_upload_ajax" enctype="multipart/form-data" id="js-upload-form">
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="file" name="image_file" id="js-upload-files"/>
                        </div>
                        <button type="submit" class="btn btn-sm btn-danger" id="js-upload-submit">Preview</button>
                    </div>
                    <input type="hidden" name="action" value="upload_ajax"/>
                </form>
                <br/>
                <br/>
                <img src="img/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
                <div id="output"></div>

            </div>
            <form method="post" action="index.php?module=upload" role="form">

                <div class="col-md-4">
                    <h3 class="title_upload">WHAT IS IT ?</h3>
                    <br/>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input required type="text" maxlength="20" placeholder="Name your work" name="name" class="form-control form-upload">
                            <br/>
                            <textarea name="description" maxlength="400" rows="3" placeholder="Description" required class="form-control form-upload textarea_upload"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <span class="modalities">Can anyone can see your upload ?</span>
                        <br/>
                        <input type="radio" name="radio_public_private" value="1" id="radio4" class="css-checkbox" checked="checked"/>
                        <label for="radio4" class="css-label radGroup2">Public</label>
                        <input type="radio" name="radio_public_private" value="0" id="radio5" class="css-checkbox" />
                        <label for="radio5" class="css-label radGroup2">Private</label>
                        <br/>
                    </div>
                    <br><br>

                    <div class="col-md-12">
                        <br/>
                        <input type="hidden" name="img" id="img_url" value="" />
                        <input type="hidden" name="size" id="product_size" value=""/>
                        <input type="hidden" name="action" id="submit_action" value="submitCraft" />
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <button type="submit" id="submit_save" class="btn btn-lg submit_form btn-another-work">Add your craft</button>
                </div>
            </form>

        </div>

        <div class="row">
            <br>
            <div class="col-md-12">
                <h4>Latest uploaded crafts</h4>
                <hr/>

                <?php

                foreach ($lastUploads as $lastUpload) {
                    ?>

                    <div class="col-sm-4 col-md-3 col-xs-6 col-lg-3">
                        <div class="thumbnail parent">
                            <a href="<?php echo (_REW_URL == true) ? "/product=>" . $lastUpload->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $lastUpload->product_id ; ?>" class="product-image"><img src="<?php echo $lastUpload->product_img_url; ?>" class="img-responsive prodIMG"></a>

                            <div class="caption">
                                <h4><?php echo $lastUpload->product_name; ?></h4>

                                <p>
                                    <small><em>By <?php echo $lastUpload->user_username; ?></em></small>
                                </p>
                                <div class="btn-group " style="float: left">
                                    <a href="<?php echo (_REW_URL == true) ? "/product=>" . $lastUpload->product_id : _PATH_FOLDER . "index.php?module=fiche&product=" . $lastUpload->product_id ; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="index.php?module=panier&action=addToCart&product=<?php echo $lastUpload->product_id; ?>&img_url=<?php echo $lastUpload->product_img_url; ?>&name=<?php echo $lastUpload->product_name; ?>&from=<?php echo $lastUpload->user_username; ?>" class="btn btn-xs ajax_cart_trigger btn-default add-to-cart"><i class="fa fa-shopping-cart"></i></a>
                                </div>
                                <div class="text-right"><?php
                                    if (isset($_SESSION[_SES_NAME]["authed"]) && $_SESSION[_SES_NAME]["authed"] == true) {
                                        if (isset($lastUpload->did_i_like) && $lastUpload->did_i_like == true) {
                                            ?>
                                            <button type="button"
                                                    data-product="<?php echo $lastUpload->product_id; ?>"
                                                    class="btn btn-xs btn-default like ajax_like_trigger"
                                                    data-didilike="1">
                                                                <span class="nb_like"
                                                                      id="nb_like<?php echo $lastUpload->product_id; ?>"><?php echo $lastUpload->nb_like; ?></span>
                                                <i data-toggle="tooltip" data-placement="top" data-html="true"
                                                   title="<?php
                                                   if (isset($lastUpload->name_likes)) {
                                                       foreach ($lastUpload->name_likes as $lastUpload->name_like) {
                                                           echo $lastUpload->name_like->user_username . '<br/>';
                                                       }
                                                       if ($lastUpload->nb_like > 5) {
                                                           $others = $lastUpload->nb_like - 5;
                                                           echo 'and ' . $others . ' others';
                                                       }
                                                   }
                                                   ?>" class="fa fa-heart" style="color: tomato"></i>
                                            </button>
                                        <?php
                                        } else {
                                            ?>
                                            <button type="button"
                                                    data-product="<?php echo $lastUpload->product_id; ?>"
                                                    class="btn btn-xs btn-default like ajax_like_trigger"
                                                    data-didilike="0">
                                                                <span class="nb_like"
                                                                      id="nb_like<?php echo $lastUpload->product_id; ?>"><?php echo $lastUpload->nb_like; ?></span>
                                                <i data-toggle="tooltip" data-placement="top" data-html="true"
                                                   title="<?php
                                                   if (isset($lastUpload->name_likes)) {
                                                       foreach ($lastUpload->name_likes as $lastUpload->name_like) {
                                                           echo $lastUpload->name_like->user_username . '<br/>';
                                                       }
                                                       if ($lastUpload->nb_like > 5) {
                                                           $others = $lastUpload->nb_like - 5;
                                                           echo 'and ' . $others . ' others';
                                                       }
                                                   }
                                                   ?>" class="fa fa-heart-o" style="color: tomato"></i>
                                            </button>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <button data-toggle="modal" data-target="#modal-login" type="button"
                                                data-product="<?php echo $lastUpload->product_id; ?>"
                                                class="btn btn-xs btn-default like">
                                                            <span class="nb_like"
                                                                  id="nb_like<?php echo $lastUpload->product_id; ?>"><?php echo $lastUpload->nb_like; ?></span>
                                            <i data-toggle="tooltip" data-placement="top" data-html="true"
                                               title="<?php
                                               if (isset($lastUpload->name_likes)) {
                                                   foreach ($lastUpload->name_likes as $lastUpload->name_like) {
                                                       echo $lastUpload->name_like->user_username . '<br/>';
                                                   }
                                                   if ($lastUpload->nb_like > 5) {
                                                       $others = $lastUpload->nb_like - 5;
                                                       echo 'and ' . $others . ' others';
                                                   }
                                               }
                                               ?>" class="fa fa-heart-o" style="color: tomato"></i>
                                        </button>
                                    <?php
                                    }
                                    ?>



                                    <!--<button type="button" class="btn btn-xs btn-default like">
                                                    <span class="nb_like" id="nb_like<?php echo $lastUpload->product_id; ?>"><?php echo $lastUpload->nb_like; ?></span> <i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart" style="color: tomato"></i>
                                                </button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                ?>



            </div>
        </div>

    </div>

    </div>
    <!--/Content-->

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>