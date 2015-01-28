$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
$(document).on('click', '.ajax_like_trigger', function () {
    if ($(this).attr("data-didilike") == 1) {
        var product = $(this).attr("data-product");
        var nb_like = $(this).find(".nb_like").html();

        nb_like--;
        $.ajax({
            // URL du traitement sur le serveur
            url: 'index.php?module=index',
            //Type de requête
            type: 'post',
            //parametres envoyés
            data: 'action=ajax_unlike_product&product=' + product,
            //on precise le type de flux
            //Traitement en cas de succes
            success: function (data) {

            },
            error: function (jqXHR, textStatus, errorThrown) {
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
            url: 'index.php?module=index',
            //Type de requête
            type: 'post',
            //parametres envoyés
            data: 'action=ajax_like_product&product=' + product,
            //on precise le type de flux
            //Traitement en cas de succes
            success: function (data) {

            },
            error: function (jqXHR, textStatus, errorThrown) {
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
