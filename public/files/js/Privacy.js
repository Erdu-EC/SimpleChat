$(document).ready(function () {
    var i=0;
    let each = $(".texto-politicas ol li h2").each (function (index, element) {
$(this).before('<a  name="seccion-'+(i+1)+'"></a>');
        var entrada = $(this).clone().text();
var elemento = '<a href="#seccion-'+(i+1)+'"><div class="elemento-indice color-'+((i%5)+1)+'"><div class="icon"><span class="material-icons">arrow_forward_ios</span></div><span class="texto">'+entrada+'</span></div></a>';

        $("#indice").append(elemento);
i= (i+1);
    });
});

//FRONTEND
$("#btn-navbar-toggler").click(function () {
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo").toggleClass("inactivo");
    if( $("nav.menu-navegacion ul.nav-lista").hasClass('activo')){
        $("#btn-navbar-toggler").html('<span class="material-icons">close</span>');
    }
    else{
        $("#btn-navbar-toggler").html('<span class="material-icons">menu</span>');
    }
});