function afterSuccessSecond()
{
    $("#form_url_ajax").addClass("hideform");
    $("#form_ajax").removeClass("hideform");
}
function afterSuccess()
{
    var img_url = $('#img_output').attr('src'); //input type hidden img url
    $('#img_url').val(img_url);

    $("#form_ajax").addClass("hideform");
    $("#form_url_ajax").removeClass("hideform");

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
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
$(document).ready(function(){
    $('.modal_supp_trigger').on('click', function (e) {
        var url = $(this).attr("data-href");
        $('#yes_button').attr("href", url) ;
    });

    $("#btn_url_ajax").on("click", function(e){
        e.preventDefault();
        var options = {
            success: afterSuccessSecond,  // post-submit callback
            resetForm: true        // reset the form after successful submit
        };

        $("#form_url_ajax").ajaxSubmit(options);

    });

    $("#btn_ajax").on("click", function(e){
        e.preventDefault();
        $("#js-upload-files").click();
    });

    $("#js-upload-files").change(function(){

        var options = {
            target: '#output',   // target element(s) to be updated with server response
            beforeSubmit: beforeSubmit,  // pre-submit callback
            success: afterSuccess,  // post-submit callback
            resetForm: true        // reset the form after successful submit
        };

        $("#form_ajax").ajaxSubmit(options);

    });
});