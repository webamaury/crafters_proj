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
        //$('#submit_action').val(val)
    });
    $("#btn_ajax").on("click", function(e){
        e.preventDefault();
        $("#js-upload-files").click();
    });


    var options = {
        target: '#output',   // target element(s) to be updated with server response
        beforeSubmit: beforeSubmit,  // pre-submit callback
        success: afterSuccess,  // post-submit callback
        resetForm: true        // reset the form after successful submit
    };

    $('#js-upload-files').on("change", function(e) {
        e.preventDefault();
        $(this).parents('form').ajaxSubmit(options);
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
