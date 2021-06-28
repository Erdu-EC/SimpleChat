$(document).ready(cargar_conversaciones);


function cargar_conversaciones() {
    const alerta = $('#alerta-conversaciones').html('');
    const lista_conversaciones = $('#lista-conversaciones').html('');

    $.ajax('/action/conversations', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        beforeSend: () => lista_conversaciones.html(ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')),
        error: () => alerta.text('No fue posible cargar las conversaciones.'),
        success: function (json) {
            if (json === null)
                alerta.text('No fue posible cargar las conversaciones.');
            else if (json.length === 0){
                lista_conversaciones.html('');
                alerta.html('No tienes ninguna conversación.<br/><br/>¡Busca un contacto y haz una!');
            }
            else {
                alerta.html('Tienes ' + json.length + ' conversacion(es)<br/><br/><small class="text-secondary">¡Busca un contacto y haz más!</small>')

                lista_conversaciones.html('');

                json.forEach((registro) => {
                    $('<li>', {
                        class: 'contact',
                        html: ObtenerElementoConversacion(registro[0], registro[1], registro[2], registro[5]),
                    }).appendTo(lista_conversaciones);
                });
            }
        }
    });
}

const ObtenerElementoConversacion = (usuario_id, nombres, apellidos, contenido) =>
    `<div class="wrap" data-usuario="${usuario_id}">
                                       <span class="contact-status online"></span>
                                       <img src="/files/profile/0_erdu.png?w=100&h=100" alt="" />
                                       <div class="meta">
                                           <p class="name">${nombres} ${apellidos}</p>
                                           <p class="preview">${contenido}</p>
                                       </div>
                                   </div>`;

$(document).on('click', '.elemento-conversacion', CargarEspacioDeChat);
