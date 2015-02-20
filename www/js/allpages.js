$(document).ready(function () {
    /*
    Keyboard shortcuts
    u: upload,
    h:home,
    g:gallery,

     */
    $(document).keypress(function(e){
        var key = e.which;
        if (key == 117) {
            if($('input:focus').length > 0 || $('textarea:focus').length > 0){
            } else {
                window.location.href = "index.php?module=upload";
                return false;
            }
        } else if (key == 104) {
            if($('input:focus').length > 0 || $('textarea:focus').length > 0){
            } else {
                window.location.href = "index.php";
                return false;
            }
        } else if (key == 103) {
            if($('input:focus').length > 0 || $('textarea:focus').length > 0){
            } else {
                window.location.href = "index.php?module=gallery";
                return false;
            }
        } else if (key == 112) {
            if($('input:focus').length > 0 || $('textarea:focus').length > 0){
            } else {
                window.location.href = "index.php?module=commande";
                return false;
            }
        }
    });


    /*
    Minimalize header
     */
    if($('body').scrollTop() > 60){
        $(".header").addClass("min-header");
        $(".content").css("margin-top", "115px");
    }
    $(window).scroll(function(){
        if($('body').scrollTop() > 60){
            $(".header").addClass("min-header");
            $(".content").css("margin-top", "115px");
            $(".hr_header").addClass("hide_hr");
        } else {
            $(".header").removeClass("min-header");
            $(".content").css("margin-top", "0px");
            $(".hr_header").removeClass("hide_hr");
        }
    });

    /*
    Close login modal for forgot modal
     */
    $('.forgot_btn').on("click", function(e){
        e.preventDefault();
        $('#modal-login').modal('hide');
        $('#modal-forgotpwd').modal('show');
    });

    $(".cnil_ajax_trigger").on("click", function(){
        $.get('index.php?module=index&action=cookieCnil', {}, function (data) {
            $(".hide_cnil").fadeOut();
        }, 'json');

    });

});