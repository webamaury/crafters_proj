function traiterFlux(flux) {
    var obj = jQuery.parseJSON(flux);

    var html = " ";
    for (var key in obj) {
        html += '<div class="col-sm-6 col-md-4 col-xs-6 col-lg-3">';
        html += '<div class="thumbnail parent">';
        html += '<a href="index.php?module=fiche&product=' + obj[key].product_id + '" class="product-image">';
        html += '<img src="' + obj[key].product_img_url + '" class="img-responsive prodIMG"></a>';
        html += '<div class="caption"><h4>' + obj[key].product_name + '</h4>';
        html += '<p><small><em>By ' + obj[key].user_username + '</em></small></p>';
        html += '<div class="btn-group " style="float: left">';
        html += '<button type="button" class="btn btn-xs btn-default"><i class="fa fa-search"></i></button>';
        html += '<a href="index.php?module=panier&action=addToCart&product=' + obj[key].product_id + '&name=' + obj[key].product_name + '&img_url=' + obj[key].product_img_url + '&from=' + obj[key].user_username + '" class="btn btn-xs btn-default ajax_cart_trigger add-to-cart"><i class="fa fa-shopping-cart"></i></a>';
        html += '</div><div class="text-right">';
        if (obj[key].did_i_like == true) {
            html += '<button type="button" data-product="' + obj[key].product_id + '" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="1">';
            html += '<span class="nb_like" id="nb_like' + obj[key].product_id + '">' + obj[key].nb_like + '</span> ';
            html += '<i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart" style="color: tomato"></i></button>';
        }
        else if (obj[key].did_i_like == false) {
            html += '<button type="button" data-product="' + obj[key].product_id + '" class="btn btn-xs btn-default like ajax_like_trigger" data-didilike="0"><span class="nb_like" id="nb_like' + obj[key].product_id + '">' + obj[key].nb_like + '</span> <i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart-o" style="color: tomato"></i></button>';
        }
        else {
            html += '<button type="button" data-product="' + obj[key].product_id + '" class="btn btn-xs btn-default like"><span class="nb_like" id="nb_like' + obj[key].product_id + '">' + obj[key].nb_like + '</span> <i data-toggle="tooltip" data-placement="top" data-html="true" title="Alie S.<br/>omom<br/>mehdi<br/>marius<br/>Lisa<br/>and 6 others" class="fa fa-heart-o" style="color: tomato"></i></button>';
        }
        html += '</div></div></div></div>';
    }
    $('#display_load_more').append(html);

}

$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $("#load_more").on("click", function (e) {
        e.preventDefault();
        $(this).append('<img id="ajax_loader" src="img/ajax-loader.gif" alt="ajax loader"/>');
        var order = $('.orderby').attr("data-order");
        var search = $('.searchval').val();
        var page = $(this).attr("data-num");
        page++;
        $(this).attr("data-num", page);
        $.ajax({
            // URL du traitement sur le serveur
            url: 'index.php?module=index',
            //Type de requête
            type: 'post',
            //parametres envoyés
            data: 'action=ajax_more&page=' + page + '&order=' + order + '&search=' + search,
            //on precise le type de flux
            //Traitement en cas de succes
            success: function (data) {
                if (data == 'no more') {
                    $('#load_more').html('no more product');
                }
                else {
                    traiterFlux(data);
                }
                $('#ajax_loader').remove();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus + " " + errorThrown);
                console.log("Erreur execution requete ajax");
            }
        });
    });

    $("#load_more_profile").on("click", function (e) {
        e.preventDefault();
        $(this).append('<img id="ajax_loader" src="img/ajax-loader.gif" alt="ajax loader"/>');
        var user = $(this).attr('data-user');
        var page = $(this).attr("data-num");
        page++;
        $(this).attr("data-num", page);
        $.ajax({
            // URL du traitement sur le serveur
            url: 'index.php?module=profile',
            //Type de requête
            type: 'post',
            //parametres envoyés
            data: 'action=ajax_more&page=' + page + '&user=' + user ,
            //on precise le type de flux
            //Traitement en cas de succes
            success: function (data) {
                if (data == 'no more') {
                    $('#load_more_profile').html('no more product');
                }
                else {
                    traiterFlux(data);
                }
                $('#ajax_loader').remove();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus + " " + errorThrown);
                console.log("Erreur execution requete ajax");
            }
        });
    });
});
