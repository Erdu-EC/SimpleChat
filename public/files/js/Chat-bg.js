$(document).ready(() => setTimeout(ObtenerMensajes, 2000))

function ObtenerMensajes(){
    $.ajax('/action/conversations', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        statusCode: {
            408: ObtenerMensajes
        },
        //error: () => alerta.text('No fue posible cargar las conversaciones.'),
        success: function (json) {

        }
    });
}