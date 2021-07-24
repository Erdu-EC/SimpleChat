$(document).ready(function () {
    var indice = $(".texto-politicas ol li h2");
    for ( i=0; i< indice.length; i++){
        var elemento = indice[i];
        $("#indice").append(elemento);
    }
});