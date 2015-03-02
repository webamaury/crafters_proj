/**
 * Created by amaurygilbon on 02/02/15.
 */

$(document).ready(function(){
    /**
     * Verif username unique ajax
     */
    $("#Username").on("keyup", function(){
        var value = $(this).val();
        if (value.length < 3) {
            $("#Username").parents('.form-group').removeClass('has-success');
            $("#Username").parents('.form-group').addClass('has-error');
            return false;
        }
        $.get('index.php?module=signup&action=usernameUniqueAjax&username=' + value, {}, function (data) {
            if (data == true) {
                $("#Username").parents('.form-group').removeClass('has-error');
                $("#Username").parents('.form-group').addClass('has-success');
            } else {
                $("#Username").parents('.form-group').removeClass('has-success');
                $("#Username").parents('.form-group').addClass('has-error');
            }
        }, 'json');
    });
    /**
     * Verif mail unique ajax
     */
    $("#Mail").on("keyup", function(){
        var value = $(this).val();
        //alert(value);
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{1,4})+$/;
        if (regex.test(value) == false) {
            $("#Mail").parents('.form-group').removeClass('has-success');
            $("#Mail").parents('.form-group').addClass('has-error');
            return false;
        }


        if (value.length < 3) {
            $("#Mail").parents('.form-group').removeClass('has-success');
            $("#Mail").parents('.form-group').addClass('has-error');
            return false;
        }
        $.get('index.php?module=signup&action=mailUniqueAjax&mail=' + value, {}, function (data) {
            if (data == true) {
                $("#Mail").parents('.form-group').removeClass('has-error');
                $("#Mail").parents('.form-group').addClass('has-success');
            } else {
                $("#Mail").parents('.form-group').removeClass('has-success');
                $("#Mail").parents('.form-group').addClass('has-error');
            }
        }, 'json');
    });
});
