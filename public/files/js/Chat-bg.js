$(document).ready(() => setTimeout(ObtenerMensajes, 1000))

function ObtenerMensajes(){
    $.ajax('/action/users/MIInstant', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        statusCode: {
            408: ObtenerMensajes
        },
        //error: () => alerta.text('No fue posible cargar las conversaciones.'),
        success: function (json) {

        }
    });
}