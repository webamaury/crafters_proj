/**
 * Animation d'ajout vers l'icone du panier
 */
$(document).on('click', '.add-to-cart', function () {
    var cart = $('.fa-shopping-cart');
    var imgtofly = $(this).parents('div.thumbnail').find('a.product-image img').eq(0);
    if (imgtofly) {
        var imgclone = imgtofly.clone()
            .offset({ top:imgtofly.offset().top, left:imgtofly.offset().left })
            .css({'opacity':'0.7', 'position':'absolute', 'height':'150px', 'width':'150px', 'z-index':'1000'})
            .appendTo($('body'))
            .animate({
                'top':cart.offset().top + 10,
                'left':cart.offset().left + 30,
                'width':55,
                'height':55
            }, 500, 'swing');
        imgclone.animate({'width':0, 'height':0}, function(){ $(this).detach() });
    }
});
/**
 * AJAX d'ajout d'un produit au panier
 */
$(document).on('click', '.ajax_cart_trigger', function (e) {
    e.preventDefault();
    $.get($(this).attr('href'),{},function(data){
        if(data.error){
            alert(data.message);
        }else{
            //SI C BON
            var nb_product = $('.nb_product_ajax').text();
            nb_product ++ ;
            $('.nb_product_ajax').text(nb_product);
        }
    },'json');
    return false;
});
/**
 * AJAX de suppression d'un produit dans le panier
 */
$(document).on('click', '.ajax_delete_trigger', function (e) {
    e.preventDefault();
    var idAjax = "#" + $(this).parent().parent("div").attr("id");
    $.get($(this).attr('href'),{},function(data){
        $(idAjax).fadeOut("500");
        $('.nb_product_ajax').text(data.nb_product);
        $('.ajax_all_quantity').text(data.nb_product + ' products');
        $('.ajax_all_price').text(data.totalPrice);

    },'json');
    return false;
});
/**
 * AJAX de modification de la quantité d'un produit dans le panier
 */
$(document).on('click', '.ajax_quantity_trigger', function (e) {
    e.preventDefault();
    var product = $(this).attr('data-id');
    $.get($(this).attr('href'),{},function(data){
        var anchor = '.ajax_quantity_display' + product;
        var quantity = data.quantity;
        var allQuantity = data.nb_product;
        if (quantity == 0) {
            $(anchor).parent().parent().parent().parent(".ajax_row").fadeOut("500");
        }

        $(anchor).html(quantity)
        $('.nb_product_ajax').text(allQuantity);
        if(allQuantity > 1) {
            allQuantity += ' products';
        } else {
            allQuantity += ' product';
        }

        $('.ajax_all_quantity').text(allQuantity);
        $('.ajax_all_price').text(data.totalPrice);

    },'json');
    return false;
});
/**
 * AJAX de modiification de la taille d'un produit
 */
$(document).on('click', '.ajax_size_trigger', function (e) {
    e.preventDefault();
    var size = $(this).attr("data-size");
    var product = $(this).attr("data-id");
    var urlAjax = 'index.php?module=panier&action=changeSize&size=' + size + '&product=' + product ;
    $.get(urlAjax,{},function(data){
        if (size == 's') {
            var classDislplay = '.size_s' + product;
        } else if (size == 'm') {
            var classDislplay = '.size_m' + product;
        } else if (size == 'l') {
            var classDislplay = '.size_l' + product;
        }
        $(classDislplay).siblings(".size_cart").addClass("ajax_size_trigger");
        $(classDislplay).siblings(".size_cart").removeClass("size_cart_select");

        $(classDislplay).addClass("size_cart_select");
        $(classDislplay).removeClass("ajax_size_trigger");
        if (size == 's') {
            var price = 5 ;
        } else if (size == 'm') {
            var price = 10 ;
        } else if (size == 'l') {
            var price = 15 ;
        }
        $(classDislplay).parent().parent().parent().next().find(".price").text(price + "€");
        $('.ajax_all_price').text(data.totalPrice);

    },'json');
    return false;
});


function traiterFlux2(flux) {
    var html = '';
    var all_quantity = 0;
    var all_price = 0;
    for (var key in flux) {
        if (flux[key].size == 's') {
            var price = 5 ;
        } else if (flux[key].size == 'm') {
            var price = 10 ;
        } else if (flux[key].size == 'l') {
            var price = 15 ;
        }
        html += '<div id="product' + key + '" class="col-md-12 ajax_row">';
        html += '<div class="col-md-3">';
        html += '<img src="' + flux[key].img_url + '" class="img-responsive">';
        html += '</div>';
        html += '<div class="col-md-6 description-achat">';
        html += '<br/>';
        html += '<p><strong>' + flux[key].name + '</strong></p>';

        html += '<p>';
        html += '<small>From ' + flux[key].from + '</small>';
        html += '</p>';
        html += '<p>';
        html += '<small>Quantity: <span class="ajax_quantity_display' + key + '">' + flux[key].quantity + '</span> <a href="index.php?module=panier&action=changeQuantity&move=less&product=' + key + '" class="ajax_quantity_trigger" data-id="' + key + '"><i class="fa fa-minus-square"></i></a> <a href="index.php?module=panier&action=changeQuantity&move=more&product=' + key + '" class="ajax_quantity_trigger" data-id="' + key + '"><i class="fa fa-plus-square"></i></a></small>';
        html += '</p>';
        html += '<p>';
        html += '<small><span class="size_title">Size: </span><span data-id="' + key + '" data-size="s" class="size_s' + key + ' size_cart';
        if (flux[key].size == 's') {
            html += ' size_cart_select';
        } else {
            html += ' ajax_size_trigger';
        }
        html +='">s</span> <span data-id="' + key + '" data-size="m" class="size_m' + key + ' size_cart';
        if (flux[key].size == 'm') {
            html += ' size_cart_select';
        } else {
            html += ' ajax_size_trigger';
        }
        html+= '">m</span> <span data-id="' + key + '" data-size="l" class="size_l' + key + ' size_cart';
        if (flux[key].size == 'l') {
            html += ' size_cart_select';
        } else {
            html += ' ajax_size_trigger';
        }
        html+='">l</span></small>';
        html += '</p>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<br/>';
        html += '<br/>';

        html += '<p class="price">' + price + '$</p>';
        html += '</div>';
        html += '<br/>';
        html += '<br/>';
        html += '<div class="col-md-1">';
        html += '<a href="index.php?module=panier&action=deleteFromCart&product=' + key + '" class="ajax_delete_trigger"><i class="fa fa-trash-o"></i></a>'
        html += '</div>';
        html += '</div>';

        all_quantity += flux[key].quantity;
        all_price += flux[key].quantity * 10 ;
    }
    if(all_quantity > 1) {
        all_quantity += ' products';
    } else {
        all_quantity += ' product';
    }

    $('.ajax_display_cart_content').html(html);
    $('.ajax_all_quantity').text(all_quantity);
    $('.ajax_all_price').text(all_price);

}
$(document).ready(function () {
    $('.ajax_display_cart').on('click', function (e) {
        //e.preventDefault();
        var url_ajax = $(this).attr("data-ajax");
        $.get(url_ajax, {}, function (data) {
            traiterFlux2(data);
        }, 'json');
        //return false;
    });
});
