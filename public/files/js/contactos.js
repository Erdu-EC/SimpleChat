$('.item-contacto .card').on('click', function(){
    $('span').removeClass('active');
    $(this).children('span').addClass('active');
});
