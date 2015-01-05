<?php include("../app/views/includes/head.inc.php") ; ?>
	
	<div class="container">

		<?php include("../app/views/includes/header.inc.php"); ?>
		

<div class="container">
    <div class="row">
         <div class="col-md-4 col-md-offset-2">
           <h3 style="text-align: right" class="title_upload">UPLOAD YOUR AWESOME WORK</h3>
             <form action="index.php?module=upload" method="post" class="form_upload_ajax" enctype="multipart/form-data" id="js-upload-form">
                 <div class="form-inline">
                     <a onclick="ga('send','event','Upload ACTION','Clique');" href="#"><div class="form-group">
                             <input type="file" name="upload_file" id="js-upload-files"/>
                         </div></a>
                     <button type="submit" class="btn btn-sm btn-danger" id="js-upload-submit">Upload files</button>
                 </div>
                 <input type="hidden" name="action" value="upload_ajax"/>
             </form>
                <br/>
                <br/>
             <br/>
             <img src="illu/12.jpg" class="img-responsive">

         </div>
        <div class="col-md-4">
            <h3 class="title_upload">WHAT IS IT ?</h3>
            <br/>
                <div class="col-md-6">
                    <form role="form">
                        <div class="form-group">
                            <a onclick="ga('send','event','Formulaire Infos','Clique');" href="#"><input type="text" placeholder="Name of your work" class="form-control form-upload"></a>
                            <br/>
                            <a onclick="ga('send','event','Formulaire Infos','Clique');" href="#"><input type="text" placeholder="Description" class="form-control form-upload-description"></a>
                        </div>
                    </form>
                </div>
            <div class="col-md-12">
                <br/>
                <span class="modalities">Can anyone can see your upload ?</span>
                <br/>
                <input type="radio" name="radio_dark" id="radio4" class="css-checkbox" checked="checked" />
                <label for="radio4" class="css-label radGroup2">Public</label>
                <input type="radio" name="radio_dark" id="radio5" class="css-checkbox" />
                <label for="radio5" class="css-label radGroup2">Private</label>
                <br/>
            </div>
            <div class="col-md-12">
                <br/>
                <span class="modalities">Choose your medium ?</span>
                <br/>
                <input type="radio" name="radiog_dark" id="radio4" class="css-checkbox" checked="checked" />
                <label for="radio4" class="css-label2 radGroup2">Tattoo</label>
                <input type="radio" name="radiog_dark" id="radio5" class="css-checkbox" />
                <label for="radio5" class="css-label2 radGroup2">Stickers</label>
            </div>
            <div class="col-md-12">
                <br/>
                <span class="modalities">Choose your size</span>
                <br/>
                <div class="btn-group " role="group" aria-label="...">
                    <button type="button" class="btn btn-default size">S</button>
                    <button type="button" class="btn btn-default size">M</button>
                    <button type="button" class="btn btn-default size">L</button>
                </div>
                <br/>
                <br/>
                <span class="modalities">How many ?</span>
                <br/>
                <input type="number" placeholder="Max: 1000" class="form-control form-quantity">
            </div>
            <div class="col-md-12">
                <br/>
                <btn class="btn btn-sm btn-danger"><a href="summary.php">Save and pay</a></btn>
                <btn class="btn btn-sm btn-danger"><a href="dashboard.html">Just save</a></btn>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="btn btn-lg btn-another-work">Add another craft</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Latest work updated</h4>
            <hr/>
            <div class="col-md-3 col-xs-6">
                <div class="thumbnail">
                    <img src="illu/2.jpg" class="img-responsive">
                    <div class="caption">
                        <h4>Angry Bear</h4>
                        <p><small><em>By Old Boy</em></small></p>
                        <div class="btn-group " style="float: left">
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-search"></i></button>
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-shopping-cart"></i></button>
                            <button type="button" class="btn btn-xs btn-default btn-primary like2"><i class="fa fa-heart-o"></i></button>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-xs btn-default like">
                                765 <i class="fa fa-heart" style="color: tomato"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="thumbnail">
                    <img src="illu/16.jpg" class="img-responsive">
                    <div class="caption">
                        <h4>Pizza my love</h4>
                        <p><small><em>By Ilovepizza</em></small></p>
                        <div class="btn-group " style="float: left">
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-search"></i></button>
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-shopping-cart"></i></button>
                            <button type="button" class="btn btn-xs btn-default btn-primary like2"><i class="fa fa-heart-o"></i></button>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-xs btn-default like">
                                965 <i class="fa fa-heart" style="color: tomato"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="thumbnail">
                    <img src="illu/3.jpg" class="img-responsive">
                    <div class="caption">
                        <h4>Camera Illustration</h4>
                        <p><small><em>By Hugo Photographer</em></small></p>
                        <div class="btn-group " style="float: left">
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-search"></i></button>
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-shopping-cart"></i></button>
                            <button type="button" class="btn btn-xs btn-default btn-primary like2"><i class="fa fa-heart-o"></i></button>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-xs btn-default like">
                                765 <i class="fa fa-heart" style="color: tomato"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="thumbnail">
                    <img src="illu/17.jpg" class="img-responsive">
                    <div class="caption">
                        <h4>Super boat</h4>
                        <p><small><em>By Captain Hadock</em></small></p>
                        <div class="btn-group " style="float: left">
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-search"></i></button>
                            <button type="button" class="btn btn-xs btn-default"><i class="fa fa-shopping-cart"></i></button>
                            <button type="button" class="btn btn-xs btn-default btn-primary like2"><i class="fa fa-heart-o"></i></button>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-xs btn-default like">
                                215 <i class="fa fa-heart" style="color: tomato"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" style="padding-top: 100px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-login-label">Log in</h4>
                </div>
                <div class="modal-body">
                    <div class="row center-block">
                        <div class="col-md-12">
                            <h3>Please Log In, or <a href="#" data-toggle="modal" data-target="#modal-new-signup">Sign Up</a></h3>
                                <form role="form">
                                    <div class="form-group">
                                        <input type="text" placeholder="Username or Email" class="form-control">
                                        <br/>
                                        <input type="password" placeholder="Password" class="form-control">
                                    </div>
                                    <a class="pull-right" href="#">Forgot password?</a>
                                    <button type="submit" class="btn btn btn-primary">
                                        Log In
                                    </button>
                                </form>
                                    <div class="login-or">
                                        <hr class="hr-or">
                                        <span class="span-or">or</span>
                                    </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <a href="#" class="btn btn-lg btn-block" style="background-color: #3b5998; border-color: #3b5998; color: white">Facebook</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <br/>
                                        <a href="#" class="new-signup">New on Crafters ? Subscribe</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



</div> <!-- /container -->


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56403954-1', 'auto');
  ga('send', 'pageview');

</script>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
	
	
	$(document).ready(function(){
		/*$('.form_upload_ajax').on("submit", function(e) {
			e.preventDefault();
			$.ajax({
				// URL du traitement sur le serveur
				url : 'index.php?module=upload',
				//Type de requête
				type: 'post',
				//parametres envoyés
				data: $(this).serialize(),
				
				dataType: 'json',
				//on precise le type de flux
				//Traitement en cas de succes
				success: function(data) {
					console.log("flux : " + data);
					alert(data);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus + " " + errorThrown);
					console.log("Erreur execution requete ajax");
				}
			});
		});*/
	});
	
</script>
</body>
</html>