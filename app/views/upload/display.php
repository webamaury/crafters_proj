<?php include("../app/views/includes/head.inc.php") ; ?>
	
	<div class="container">

		<?php include("../app/views/includes/header.inc.php"); ?>
		

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
        	<h3 style="text-align: right" class="title_upload">UPLOAD YOUR AWESOME WORK</h3>
            	<form action="index.php?module=upload" method="post" class="form_upload_ajax" enctype="multipart/form-data" id="js-upload-form">
                	<div class="form-inline">
	                    	<div class="form-group">
                            	<input type="file" name="image_file" id="js-upload-files"/>
                        	</div>
						<button type="submit" class="btn btn-sm btn-danger" id="js-upload-submit">Upload file</button>
                	</div>
					<input type="hidden" name="action" value="upload_ajax"/>
            	</form>
             <br/>
             <br/>
			 <img src="img/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
             <div id="output"></div>

         </div>
        <div class="col-md-4">
            <h3 class="title_upload">WHAT IS IT ?</h3>
            <br/>
            <form method="post" action="index.php?module=upload" role="form">
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
	            <div class="col-md-12">
	                <br/>
	                <span class="modalities">Choose your medium ?</span>
	                <br/>
	                <input type="radio" name="radio_tatoo_stickers" value="tattoo" id="radio2" class="css-checkbox" checked="checked" />
	                <label for="radio2" class="css-label2 radGroup2">Tattoo</label>
	                <input type="radio" name="radio_tatoo_stickers" value="stickers" id="radio3" class="css-checkbox" />
	                <label for="radio3" class="css-label2 radGroup2">Stickers</label>
	            </div>

	            <div class="col-md-12">
	                <br/>
	                <input type="hidden" name="img" id="img_url" value="" />
	                <input type="hidden" name="size" id="product_size" value=""/>
	                <input type="hidden" name="action" id="submit_action" value="" />
	                <button type="submit" id="submit_pay" class="btn btn-sm btn-danger submit_form">Save and pay</button>
	                <button type="submit" id="submit_save" class="btn btn-sm btn-danger submit_form">Just save</button>
	            </div>
            </form>
        </div>
    </div>

    <div class="row">
    <br>
        <div class="col-md-12">
            <div class="btn btn-lg btn-another-work">Add another craft</div>
        </div>
    </div>

    <div class="row">
        <br>
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






</div> <!-- /container -->


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56403954-1', 'auto');
  ga('send', 'pageview');

</script>

    <script type="text/javascript" src="tools/jQuery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="tools/bootstrap-3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="tools/plugin_jquery/jquery.form.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	
	$('.size').on("click", function(){
		var size = $(this).attr('id');
		$('#product_size').val(size);
	});
	$('.submit_form').on("click", function(){
		if($('#img_url').val() == ''){
			$('#output').html('no image to load!');
			return false;
		}
		var val = $(this).attr('id');
		$('#submit_action').val(val)
	});
	
	
	var options = { 
			target: '#output',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmit,  // pre-submit callback 
			success: afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#js-upload-form').submit(function(e) { 
			e.preventDefault();
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
}); 

function afterSuccess()
{
	$('#js-upload-submit').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	var img_url = $('#img_output').attr('src'); //input type hidden img url
	$('#img_url').val(img_url);

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#js-upload-files').val()) //check empty input filed
		{
			$("#output").html("Are you kidding me?");
			return false
		}
		
		var fsize = $('#js-upload-files')[0].files[0].size; //get file size
		var ftype = $('#js-upload-files')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#js-upload-submit').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older browsers that do not support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

</script>

<?php include(_APP_PATH . "views/includes/footer.inc.php"); ?>