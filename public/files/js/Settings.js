$(document).on("click", "#btn-configuraciones", function () {
    CargarEspacioConfiguraciones();
});

function CargarEspacioConfiguraciones(){
    $('#espacio-de-chat').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).load(`/Settings`);
};