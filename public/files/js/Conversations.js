$(document).ready(cargar_conversaciones);

$(document).on('click', '.elemento-conversacion', CargarEspacioDeChat);

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
                        class: 'list-group-item ps-0 pe-0',
                        html: ObtenerElementoConversacion(registro[0], registro[1], registro[2], registro[6]),
                    }).appendTo(lista_conversaciones);
                });
            }
        }
    });
}

const ObtenerElementoConversacion = (usuario_id, nombres, apellidos, contenido) =>
    `<div class="card mb-2 elemento-conversacion" style="cursor: pointer;" data-usuario="${usuario_id}">
        <div class="row g-0">
            <div class="col-md-3 p-1">
                <img src="/files/profile/0_erdu.png" class="img-fluid" alt="Foto de perfil">
            </div>
            <div class="col-md-9 align-self-center">
                <div class="card-body p-2">
                    <h6 class="card-title">${nombres} ${apellidos}</h6>
                    <p class="card-text" style="font-size: .8rem;"><small class="text-muted">${contenido}</small></p>
                </div>
            </div>
        </div>
    </div>`;