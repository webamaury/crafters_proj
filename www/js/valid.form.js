$(document).ready(function(){
    $(".confirm_password").on("keyup", function(){
        var value = $(this).val();
        var new_mail = $('.new_password').val();
        $(this).attr("pattern", new_mail)

        if (value == new_mail) {
            $(this).parents("div.form-group").removeClass("has-error");
            $(this).parents("div.form-group").addClass("has-success");
        } else {
            -					$(this).parents("div.form-group").removeClass("has-success");
            $(this).parents("div.form-group").addClass("has-error");
        }
        if (value == "") {
            $(this).parents("div.form-group").removeClass("has-error");
            $(this).parents("div.form-group").removeClass("has-success");
        }
    })
});
