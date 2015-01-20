<?php include("../app/views/includes/head.inc.php") ; ?>
	
	<div class="container">

		<?php include("../app/views/includes/header.inc.php"); ?>
		

		<div class="container">
		    <div class="row">
		        <div class="col-sm-6 col-md-4">
		            <div class="row">
		                <div class="col-md-4 header_video">
		                    <iframe id="ytplayer" type="text/html" width="354" height="199"
		                            src="https://www.youtube.com/embed/hzbq6XM9zTU?autoplay=0&controls=0&fs=0&modestbranding=1&rel=0&showinfo=0&autohide=1&color=white&theme=light"
		                            frameborder="0" allowfullscreen>
		                    </iframe>                  
		                    <br>
		                    <?php
			                    if(isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] == true){
				            	?>
							<a href="index.php?module=upload" onclick="ga('send','event','Upload','Clique');" class="btn upload-2 upload-2c star">Start uploading your work</a>
								<?php
			                    }
			                    else {
				                ?>
							<a href="#" onclick="ga('send','event','Upload','Clique');" data-toggle="modal" data-target="#modal-login" class="btn upload-2 upload-2c star">Start uploading your work</a>
				                <?php
			                    }
		                    ?>
		                    <br>
		                    <br/>
		                    <br/>
		                </div>
		                    <div class="row">
		
		                        <div class="col-md-12">
		                            <h2 style="text-transform: uppercase; font-size: 20px; ">Crafter of the month</h2>
		                            <hr>
		                        </div>
		                            <div class="col-md-5 col-sm-3 col-xs-5">
		                                <a href="index.php?module=profil&user=<?php echo $crafter_of_month->user_id ; ?>"><img src="<?php echo $crafter_of_month->user_img_url ; ?>" class="img-responsive img-circle" style="float: right"></a>
		                            </div>
		                            <div class="col-md-6 col-sm-9 col-xs-7">
		                                <br/>
		                                <a onclick="ga('send','event','Crafter of the month','Clique');" href="#"></a><h2><?php echo $crafter_of_month->user_username ; ?></h2></a>
		                                <p><?php echo $crafter_of_month->user_description ; ?></p>
		                                <?php foreach($user_month_products as $user_month_product) { ?>
		                                <img src="<?php echo $user_month_product->product_img_url ; ?>" alt="<?php echo $user_month_product->product_name ; ?>" title="<?php echo $user_month_product->product_name ; ?>" width="40px">
		                                <?php } ?>
		                                <br/>
		                                <span onclick="ga('send','event','Crafter of the month','Clique');" class="seemore"><a href="index.php?module=profil&user=<?php echo $crafter_of_month->user_id ; ?>" >See her creations</a></span>
		                                <br/>
		                                <br/>
		                                <br/>
		                            </div>
		
		                        <div class="col-md-12 ">
		                            <h2 style="text-transform: uppercase; font-size: 20px; ">Most Popular Crafters</h2>
		                            <hr>
		                        </div>
		                        <?php
			                        foreach($popular_crafters as $popular_crafter) {
				                ?>
		                        <div class="col-md-3 col-sm-3 col-xs-3">
		                            <a href="index.php?module=profil&user=<?php echo $popular_crafter->user_id_product ; ?>"><img src="<?php echo $popular_crafter->user_img_url ; ?>" class="img-responsive img-circle" style="float: right"></a>
		                        </div>
		                        <div class="col-md-9 col-sm-9 col-xs-7">
		                            <br/>
		                            <a href="index.php?module=profil&user=<?php echo $popular_crafter->user_id_product ; ?>"><h2><?php echo $popular_crafter->user_username ; ?></h2></a>
		                            <?php
			                            foreach($popular_crafter->creas as $popular_crafter->crea) {
				                    ?>
		                            	<img src="<?php echo $popular_crafter->crea->product_img_url ; ?>" alt="<?php echo $popular_crafter->crea->product_name ; ?>" title="<?php echo $popular_crafter->crea->product_name ; ?>" width="30px">
				                    <?php
			                            }
		                            ?>		
		
		                            <br/>
		                            <span class="seemore"><a href="index.php?module=profil&user=<?php echo $popular_crafter->user_id_product ; ?>" >See his creations</a></span>
		                            <br/>
		                            <br/>
		                            <br/>
		                        </div>
				                <?php
			                        }
		                        ?>
		                    </div>
		            </div>
		        </div>
		
		
		    <div class="container big-gallery">
		        <div class="col-sm-8 col-md-8 big-container">
		            <span class="title-gallery">CRaFTERS LaST UPLOaD</span>
		            <!--<form class="navbar-form navbar-right" role="search">
		                <div class="form-group">
		                    <input type="text" class="form-control" placeholder="Search">
		                </div>
		                <button type="submit" class="btn btn-default">Submit</button>
		            </form>-->
		        </div>
		
		        <div class="col-sm-6 col-md-8">
		            <div id="display_load_more" class="row">
		                
		                <?php
			                foreach($products as $product) {
				            ?>
		                <div class="col-sm-6 col-md-4 col-xs-6 col-lg-3">
		                    <div class="thumbnail">
		                        <a onclick="ga('send','event','Gallery','Clique');" href="index.php?module=fiche&product=<?php echo $product->product_id ; ?>"><img src="<?php echo $product->product_img_url ; ?>" class="img-responsive"></a>
		                        <div class="caption">
		                            <h4><?php echo $product->product_name ; ?></h4>
		                            <p><small><em>By <?php echo $product->user_username ; ?></em></small></p>
		                            <div class="btn-group " style="float: left">
		                                <a href="index.php?module=fiche&product=<?php echo $product->product_id ; ?>" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		                                <button type="button" class="btn btn-xs btn-default"><i class="fa fa-shopping-cart"></i></button>
		                                <!--<button type="button" data-product="<?php echo $product->product_id ; ?>" <?php 
			                                if(isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] == true) { 
				                                if($product->did_i_like == true){ echo 'class="btn btn-xs btn-default btn-primary like2 btn-tomato ajax_like_trigger" data-didilike="1"'; }
				                                else { echo 'class="btn btn-xs btn-default btn-primary like2 ajax_like_trigger" data-didilike="0"' ;}}
				                            else { echo 'class="btn btn-xs btn-default btn-primary like2"  data-toggle="modal" data-target="#modal-login"' ;} ?>
				                             ><i class="fa fa-heart-o"></i></button>-->
		                            </div>
		                            <div class="text-right"><?php 
			                                if(isset($_SESSION["CRAFTERS-USER"]["authed"]) && $_SESSION["CRAFTERS-USER"]["authed"] == true) { 
				                                if($product->did_i_like == true){ 
					                                ?>
					                    <button type="button" data-product="<?php echo $product->product_id ; ?>" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="1">
					                    	<span class="nb_like" id="nb_like<?php echo $product->product_id ; ?>"><?php echo $product->nb_like ; ?></span> 
					                    	<i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart" style="color: tomato"></i>
				                        </button>
					                                <?php
						                        }
				                                else { 
				                                	?>
					                    <button type="button" data-product="<?php echo $product->product_id ; ?>" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="0">
					                    	<span class="nb_like" id="nb_like<?php echo $product->product_id ; ?>"><?php echo $product->nb_like ; ?></span> 
					                    	<i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart-o" style="color: tomato"></i>
				                        </button>
				                                	<?php
					                            }
					                        }
				                            else { 
					                            ?>
					                    <button type="button" data-product="<?php echo $product->product_id ; ?>" class="btn btn-xs btn-default like">
					                    	<span class="nb_like" id="nb_like<?php echo $product->product_id ; ?>"><?php echo $product->nb_like ; ?></span> 
					                    	<i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart-o" style="color: tomato"></i>
				                        </button>
					                            <?php
						                    } 
						                    ?>
				                             
				                             
				                             	
										<!--<button type="button" class="btn btn-xs btn-default like">
		                                    <span class="nb_like" id="nb_like<?php echo $product->product_id ; ?>"><?php echo $product->nb_like ; ?></span> <i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart" style="color: tomato"></i>
		                                </button>-->
		                            </div>
		                        </div>
		                    </div>
		                </div>
				            <?php
			                }
		                ?>
		            </div>
		            <div class="row ">
		                <div class="col-md-12 text-center">
		                    <a id="load_more" data-num="1" href="#">load more...</a>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		
		
		
		<div class="modal" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" style="padding-top: 100px;">
		    <div class="modal-dialog modal-sm">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                <h4 class="modal-title" id="modal-login-label">Log in</h4>
		            </div>
		            <div class="modal-body">
		                <div class="row center-block">
		                    <div class="col-md-12">
		
		                        <h3>Please Log In, or <a href="#" data-toggle="modal" data-target="#modal-new-signup">Sign Up</a></h3>
		
		                        <form role="form" method="post" action="#">
		                            <div class="form-group">
		                                <input type="text" name="email" placeholder="Username or Email" class="form-control" required>
		                                <br/>
		                                <input type="password" name="password" placeholder="Password" class="form-control" required>
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
		                                <a href="#" class="new-signup">New on Crafters ? Subscribe</a>
		                            </div>
		                        </div>
		
		                    </div>
		
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		            </div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		
		    <!-- CREDIT CARD - SHOPPING BAG -->
		    <div class="modal" id="modal-shoppingbag" tabindex="-1" role="dialog" aria-labelledby="modal-shoppingbag-label" aria-hidden="true" style="padding-top: 100px;">
		        <div class="modal-dialog">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                    <h4 class="modal-title" id="modal-shoppingbag-label">Your shopping bag</h4>
		                </div>
		                <div class="modal-body">
		                    <div class="row center-block">
		                        <div class="col-md-12">
		                            <h3 class="text-center">2 items</h3>
		                            <hr/>
		                            <br/>
		                            <form role="form">
		                                <div class="col-md-12">
		                                    <div class="col-md-4">
		                                        <img src="illu/stickers/13.jpg" class="img-responsive">
		                                    </div>
		                                    <div class="col-md-5 description-achat">
		                                        <br/>
		                                        <p><strong>Stickers Mac 13' Minion</strong></p>
		                                        <p><small>From Gru Bell</small></p>
		                                    </div>
		                                    <div class="col-md-3">
		                                        <br/>
		                                        <br/>
		                                        <p class="price">9$</p>
		                                    </div>
		                                </div>
		                                <div class="col-md-12">
		                                    <div class="col-md-4">
		                                        <img src="illu/13.jpg" class="img-responsive">
		                                    </div>
		                                    <div class="col-md-5 description-achat">
		                                        <br/>
		                                        <p><strong>Geometric illusion</strong></p>
		                                        <p><small>From Geo Trouvetout</small></p>
		                                        <p><small>Quantity: 2</small></p>
		                                    </div>
		                                    <div class="col-md-3">
		                                        <br/>
		                                        <br/>
		                                        <p class="price">9$</p>
		                                    </div>
		                                </div>
		                            </form>
		                        </div>
		                    </div>
		                </div>
		                <div class="modal-footer">
		                    <button class="btn btn-danger"><a href="#">Buy it</a> </button>
		                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		                </div>
		            </div><!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
		    </div><!-- /.modal -->
		
		
		
		    <!-- CONTACT -->
		    <div class="modal" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="modal-contact-label" aria-hidden="true" style="padding-top: 100px;">
		        <div class="modal-dialog">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                    <h4 class="modal-title text-center" id="modal-contact-label">CONTACT</h4>
		                </div>
		                <div class="modal-body">
		                    <div class="row center-block">
		                        <div class="col-md-12 text-center">
		                            <br/>
		                            <img src="img/contact_mail-01.png" class="img-responsive center-block">
		                            <br/>
		                            <p>A problem? A question ? Please send us a message</p>
		
		                            <hr>
		                        </div>
		                    </div>
		                </div>
		                        <div class="row">
		                            <div class="col-md-12 col-lg-12">
		                                    <div class="row">
		                                        <div class="col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1">
		                                            <div class="form-group">
		                                                <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
		                                                <p class="help-block text-danger"></p>
		                                            </div>
		                                            <div class="form-group">
		                                                <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
		                                                <p class="help-block text-danger"></p>
		                                            </div>
		                                            <div class="form-group">
		                                                <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
		                                                <p class="help-block text-danger"></p>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-7 col-lg-7">
		                                            <div class="form-group">
		                                                <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
		                                                <p class="help-block text-danger"></p>
		                                            </div>
		                                        </div>
		                                        <div class="clearfix"></div>
		                                        <div class="col-lg-12 text-center">
		                                            <div id="success"></div>
		                                            <button type="submit" class="btn btn-xl">Send Message</button>
		                                        </div>
		                                    </div>
		                            </div>
		                        </div>
		
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		                </div>
		            </div><!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
		    </div><!-- /.modal -->
		
		
		
		
		</div> <!-- /container -->
		
		
		
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script type="text/javascript" src="tools/jQuery/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="tools/bootstrap-3.2.0/js/bootstrap.min.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-56403954-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
		<script>
			function traiterFlux(flux) {
				var obj = jQuery.parseJSON( flux );
				/*obj.forEach(function(){
					alert(obj[0].product_name);
				});*/
					var html = " ";
				for (var key in obj){
					html += '<div class="col-sm-6 col-md-4 col-xs-6 col-lg-3"><div class="thumbnail"><a href="index.php?module=fiche&product=' + obj[key].product_id + '"><img src="' + obj[key].product_img_url + '" class="img-responsive"></a><div class="caption"><h4>' + obj[key].product_name + '</h4><p><small><em>By ' + obj[key].user_username + '</em></small></p><div class="btn-group " style="float: left"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-search"></i></button><button type="button" class="btn btn-xs btn-default"><i class="fa fa-shopping-cart"></i></button><button type="button"  data-product="' + obj[key].product_id + '" ';
					if(obj[key].did_i_like == true){ html += 'class="btn btn-xs btn-default btn-primary like2 btn-tomato ajax_like_trigger" data-didilike="1"'; }
					else if(obj[key].did_i_like == false) { html += 'class="btn btn-xs btn-default btn-primary like2 ajax_like_trigger" data-didilike="0"'; }
					else { html += 'class="btn btn-xs btn-default btn-primary like2"'; }
					html += 'class="btn btn-xs btn-default btn-primary like2"><i class="fa fa-heart-o"></i></button></div><div class="text-right"><button type="button" class="btn btn-xs btn-default like"><span class="nb_like" id="nb_like' + obj[key].product_id + '">' + obj[key].nb_like + '</span> <i class="fa fa-heart" style="color: tomato"></i></button></div></div></div></div>';
				}
				$('#display_load_more').append(html);

				/*var img_url = 'img/photo_' + obj.id + '.jpg';
				ImageExist(img_url);
				
				$(".ajax_firstname").text(obj.firstname);
				$(".ajax_name").text(obj.name);
				$(".ajax_mail").text(obj.mail);
				$(".ajax_statut").text(obj.nom);
				$(".ajax_phone").text(obj.phone);*/		
		
				//alert( obj.name );
				//var obj = jQuery.parseJSON(flux);
				//alert(obj.name);
				/*$.each(flux, function(key,value) {
					if(key == 'name') {
					$('.ajax_name').text(value);
					}
					//contenu += "<li>Key : "+key+" - Value : "+value+"</li>";
				});*/
				//$(affichage).html(contenu);
		
			}

			
			$(document).ready(function(){
				$(function () {
				  $('[data-toggle="tooltip"]').tooltip()
				});
				$("#load_more").on("click", function(e){
					e.preventDefault();
					$(this).parent().append('<img id="ajax_loader" src="img/ajax-loader.gif" alt="ajax loader"/>');
					var page = $(this).attr("data-num");
					page ++ ;
					$(this).attr("data-num", page);
					$.ajax({
						// URL du traitement sur le serveur
						url : 'index.php?module=index',
						//Type de requête
						type: 'post',
						//parametres envoyés
						data: 'action=ajax_more&page=' + page,
						//on precise le type de flux
						//Traitement en cas de succes
						success: function(data) {
							if(data == 'no more'){
								$('#load_more').parent().html('no more product');
							}
							else {
								traiterFlux(data);
							}
							$('#ajax_loader').remove();
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(textStatus + " " + errorThrown);
							console.log("Erreur execution requete ajax");
						}
					});
				});
			});
			$(document).on('click', '.ajax_like_trigger', function(){ 
					if($(this).attr("data-didilike") == 1){
						var product = $(this).attr("data-product");
						var nb_like = $(this).find(".nb_like").html();

						nb_like--;
						$.ajax({
							// URL du traitement sur le serveur
							url : 'index.php?module=index',
							//Type de requête
							type: 'post',
							//parametres envoyés
							data: 'action=ajax_unlike_product&product=' + product,
							//on precise le type de flux
							//Traitement en cas de succes
							success: function(data) {
								
							},
							error: function(jqXHR, textStatus, errorThrown) {
								console.log(textStatus + " " + errorThrown);
								console.log("Erreur execution requete ajax");
							}
						});
						$(this).find(".nb_like").html(nb_like++);
						$(this).find("i").removeClass("fa-heart");
						$(this).find("i").addClass("fa-heart-o");

						$(this).attr("data-didilike", "0");
					}
					else {

						var product = $(this).attr("data-product");
						var nb_like = $(this).find(".nb_like").html();
	
						nb_like++;
	
						$.ajax({
							// URL du traitement sur le serveur
							url : 'index.php?module=index',
							//Type de requête
							type: 'post',
							//parametres envoyés
							data: 'action=ajax_like_product&product=' + product,
							//on precise le type de flux
							//Traitement en cas de succes
							success: function(data) {
								
							},
							error: function(jqXHR, textStatus, errorThrown) {
								console.log(textStatus + " " + errorThrown);
								console.log("Erreur execution requete ajax");
							}
						});
						$(this).find(".nb_like").html(nb_like++);
						$(this).find("i").removeClass("fa-heart-o");
						$(this).find("i").addClass("fa-heart");
						$(this).attr("data-didilike", "1");
					}
			});

		</script>
		
	</body>
</html>
