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