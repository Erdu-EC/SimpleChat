$(document).ready(() => setTimeout(ObtenerMensajes, 1000))

function ObtenerMensajes(){
    console.log('Lanzando petición ')
    $.ajax('/action/users/MIInstant', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        statusCode: {
            408: ObtenerMensajes
        },
        //error: () => alerta.text('No fue posible cargar las conversaciones.'),
        success: function (json) {
            console.log(json);
            ObtenerMensajes();
        }
    });
}