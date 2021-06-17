$(document).ready();

function cargar_conversaciones() {
    const alerta = $('#alerta-conversaciones').html('');
    const lista_conversaciones = $('#lista-conversaciones').html('');

    $.ajax('/action/conversations', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        beforeSend: () => lista_conversaciones.html(ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')),
        error: () => alerta.text('No fue posible cargar la lista de contactos.'),
        success: function (json) {
            if (json === null)
                alerta.text('No fue posible cargar la lista de contactos.');
            else if (json.length === 0){
                lista_contactos.html('');
                alerta.html('Tu lista de contactos esta vacia.<br/><br/>¡Busca nuevos contactos y agregalos!');
            }
            else {
                alerta.html('Tienes ' + json.length + ' contacto(s)<br/><br/><small class="text-secondary">¡Busca nuevos contactos y agregalos!</small>')

                $('#lista-contactos').html('')

                json.forEach((registro) => {
                    $('<li>', {
                        class: 'list-group-item ps-0 pe-0',
                        html: ObtenerElementoContacto(registro[0], registro[1], registro[2], registro[3]),
                    }).appendTo(lista_contactos);
                });
            }
        }
    });
}