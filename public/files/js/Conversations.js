//Funcion que se ejecuta al cargar la pagina web
//se cargan las conversaciones con los contactos agregados y no agregados
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
            else if (json.length === 0) {
                lista_conversaciones.html('');
                alerta.html('No tienes ninguna conversación.<br/><br/>¡Busca un contacto y haz una!');
            } else {
                alerta.html('Tienes ' + json.length + ' conversacion(es)<br/><br/><small class="text-secondary">¡Busca un contacto y haz más!</small>')

                lista_conversaciones.html('');

                json.forEach((registro) => {
                    var estado='';
                    switch(registro[4]){
                        case 'I':
                            estado='inactivo';
                            break;
                        case 'A':
                            estado= 'online'
                            break;
                        case 'O':
                            estado ='ocupado';
                            break;
                    }

                    $('<li>', {
                        class: 'contact',
                        html: ObtenerElementoConversacion(registro[0], registro[1], registro[2], registro[3],estado, registro[6], registro[8], registro[5], registro[9]),
                    }).appendTo(lista_conversaciones);
                });
            }
        }
    });
}

const ObtenerElementoConversacion = (usuario_id, nombres, apellidos, foto_perfil, estado,hay_invitacion, contenido, enviado, ult_msj) =>

    `<div class="wrap elemento-conversacion" data-usuario="${usuario_id}">
<div class="conversacion-perfil">
<span class="contact-status ${estado}"></span>
        <img src="${foto_perfil}?w=100&h=100" alt="" />
</div>
        
        <div class="meta">
            <p class="name">${nombres} ${apellidos}</p>
            <div class="preview">${
        (contenido === null && hay_invitacion) ?
            '<i>Tienes una invitacion.</i>' :
            (contenido === null) ?
                '<i>Has rechazado una invitación.</i>' :
                (enviado) ? '<span class="material-icons">done</span>' + contenido : contenido

    }
            </div>
        </div>
        <div class="msj-pendientes ">
        <div class="hora-ult-mesj">
        ${Fecha_hora_ultima_Mensaje(ult_msj)}
</div>
</div>
    </div>`;

//<div class="num-msj-pendientes anterior"><span>n</span></div> -> para notificaciones vistas

const obtener_elemento_msg_pendientes = (num) => '<div class="num-msj-pendientes online"><span>' + num + '</span></div>';

