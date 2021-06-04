$('.item-contacto .card').on('click', function(){

   $(".btn-mas span").removeClass('active');
  $(this).children('.btn-mas span').addClass('active');
  var icono= $(this).children('.btn-mas').children('span').addClass('active');

});
