$(document).ready(function(){

	$(".alert").delay( 3500 ).fadeOut()

	$('.tips-trigger').tooltip();

	$('.modal-supp-trigger').on('click', function (e) {
	 	var mail = $(this).attr("data-mail");
	 	$("#mail_space").text(mail);
	 	$("#input_mail").val(mail);
	});
	
	$('.modal-supp-trigger').on('click', function (e) {
  		var url = $(this).attr("data-href");
  		$('#yes_button').attr("href", url) ;
	});


});
