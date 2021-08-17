//FRONTEND
$(".container-fluid").scroll(function() {
    if ($(this).scrollTop() > 200) {
        $("#hacia-arriba").addClass('visible');

    } else {
        $("#hacia-arriba").removeClass('visible');
    }
});

$('#hacia-arriba').on('click', function() {
    $(".container-fluid").animate({scrollTop: 0}, 600);
});


$(document).ready(function () {
    var myCarousel = document.querySelector('#carrusel-desarrolladores')
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 1500,

    })

});


$("#btn-navbar-toggler").click(function () {
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo").toggleClass("inactivo");
});