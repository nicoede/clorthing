$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
     }, 850);
});

$(document).ready(function(){

	$('#page_effect').fadeIn(2000);

});