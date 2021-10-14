$(document).ready(function () {
    //Lanzar un service worker.
    if (navigator.serviceWorker) {
        navigator.serviceWorker.register("/ServiceWorker.js").then(function (reg) {
            //console.log('ServiceWorker registration successful with scope: ', reg.scope);
        }, function () {
            console.log('Error al registrar el service worker.');
        });
    }

    //Siempre lanzar el service worker.
    if (window.Worker) {
        const chatWorker = new Worker('/files/js/Chat-bg.js');
        chatWorker.onmessage = function (ev) {
            //Si hay mensajes no leidos.
            if (ev.data['messages'].length > 0)
                TratarMensajes(ev.data['messages']);

            //Si hay invitaciones no recibidas.
            if (ev.data['invitations'].length > 0)
                TratarInvitaciones(ev.data['invitations']);

            //Si hay cambios de estado no recibidos.
            if (ev.data['msg_states'].length > 0)
                TratarCambiosDeEstadosEnMensajes(ev.data['msg_states']);
        }
    }
});

function TratarMensajes(mensajes) {
    mensajes.forEach(row => {
        const lista_conversaciones = $('#lista-conversaciones');
        let elemento_contacto = lista_conversaciones.find(`.contact > div[data-usuario=${row.user_name}]`);
        const nombre = row.first_name + " " + row.last_name;
        var texto_saneado = SanearTexto(row.content);

        //Si no existe conversacion, agregarla.
        if (elemento_contacto.length === 0) {
            elemento_contacto = $('<li>', {
                class: 'contact',
                html: ObtenerElementoConversacion(row.user_name, row.first_name, row.last_name, row.profile, null, null, texto_saneado, row.send_date, row.send_date, row.rcv_date, row.read_date)
            });
            elemento_contacto.prependTo(lista_conversaciones);
        }

        //Si el mensaje es para el contacto de la actual conversación abierta en el chat.
        if (row.user_name === $('#lista-conversaciones li.active .elemento-conversacion').attr("data-usuario")) {
            MostrarMensajeEnEspacioDeChat(nombre, row);
        } else {
            MensajeNuevo(row.id, nombre, row.content, row.profile);

            // Agregar mensaje a la lista de mensajes en buffer
            AgregarMensajesABufferChat(row);

            //Contar mensajes no leidos.
            const msg_pendientes = elemento_contacto.find('.num-msj-pendientes.online span');

            if (msg_pendientes.length === 0) {
                elemento_contacto.find('.msj-pendientes').append(obtener_elemento_msg_pendientes(1));
            } else
                msg_pendientes.text(parseInt(msg_pendientes.text()) + 1);
        }

        //Mover conversación hacia arriba en la lista de conversaciónes.
        elemento_contacto.parent().prependTo(lista_conversaciones);

        //Mostrar vista previa del mensaje en lista de conversaciones.
        elemento_contacto.find('.hora-ult-mesj').text(Fecha_hora_ultima_Mensaje(row.send_date));
        elemento_contacto.find('.preview').text(row.content_img !== null ? 'Imagen' : row.content);

        //Actualizar total de conversaciones no leidas.
        ActualizarTotalDeConversacionesNoLeidas();
    })
}

function MostrarMensajeEnEspacioDeChat(nombre, datos) {
    let mensaje;

    if (datos.content_img !== null) {
        mensaje = ObtenerElementoImgContacto(datos.profile, datos.content_img.split('\\').pop().split('/').pop(), datos.content_img, ObtenerHora(datos.send_date));
    } else
        mensaje = $(ObtenerElementoMensajeContacto(datos.profile, datos.content, ObtenerHora(datos.send_date)));


    AgregarMensajeEnEspacioDeChat(mensaje, datos.send_date);
    mensaje[0].scrollIntoView();

    NotificacionesEscritorio(datos.id, nombre, datos.content, datos.profile);

    //Enviar leido al servidor.
    MarcarComoLeido(datos.id_msg, null);
}

function ActualizarTotalDeConversacionesNoLeidas() {
    const elementos_msg_pendientes = $(`#lista-conversaciones .contact .num-msj-pendientes.online`);
    const icono_contador = $('#icon-indicador-mensaje span');

    if (elementos_msg_pendientes.length === 0)
        icono_contador.parent().hide();
    else
        icono_contador.text(elementos_msg_pendientes.length).parent().show();
}


function TratarInvitaciones(inv_list) {
    const lista_conversaciones = $('#lista-conversaciones');

    inv_list.forEach(row => {
        const elemento = lista_conversaciones.find(`.contact > div[data-usuario=${row.nick}]`);
        const elemento_html = ObtenerElementoConversacion(row.nick, row.first_name, row.last_name, row.profile, null, true, null, row.send_date, row.send_date, row.rcv_date, null);

        if (elemento.length === 0) {
            $('<li>', {
                class: 'contact',
                html: elemento_html
            }).prependTo(lista_conversaciones)
        } else {
            //Subirlo a parte superior de lista de conversaciones.
            // y Modificar html existente.
            elemento.parent().html(elemento_html).prependTo(lista_conversaciones);
        }

        NotificacionesEscritorio(row.nick, row.first_name + " " + row.last_name, elemento.find('.preview').text(), row.profile);
    })
}

function TratarCambiosDeEstadosEnMensajes(datos) {
    const lista = $('#lista-mensajes');

    datos.forEach(row => {
        const extra_mensaje = lista.find(`.enviado[data-id=${row.id_msg}] .extra-mensaje`);
        const estado = row.read_date != null ? 3 : 2;

        extra_mensaje.html(ObtenerElementoExtraMensaje(extra_mensaje.find('> .extra > span:first-child').text(), estado));

        //Actualizar conversación.
        let elemento_contacto = $(`#lista-conversaciones .contact > div[data-usuario=${row.destination}] .preview`);
        elemento_contacto.find(' > :first-child').remove();
        $(IndicadorEstadoMensaje(row.receive_date, row.read_date)).prependTo(elemento_contacto);

        //Si el mensaje ya ha sido leido eliminar id.
        if (estado === 3) extra_mensaje.parent().attr('data-id', null);
    });
}


function AgregarMensajesABufferChat(datos){
    if (buffer_chat.has(datos.user_name)){
        let mensaje;
        if (datos.content_img !== null){
            datos.content= nombre +" te ha enviado una imagen.";
            mensaje = ObtenerElementoImgContacto(datos.profile, datos.content_img.split('\\').pop().split('/').pop(), datos.content_img, ObtenerHora(datos.send_date));
        }else {
            mensaje = $(ObtenerElementoMensajeContacto(datos.profile, datos.content, ObtenerHora(datos.send_date)));
        }
        mensaje.attr("data-id", datos.id_msg);
        let espacio_chat = $(buffer_chat.get(datos.user_name));
        espacio_chat.find("#lista-mensajes").append(mensaje);
        buffer_chat.set(datos.user_name,espacio_chat  );
        return;
    }
}
function TratarCambiosDeEstadosEnMensajesRecibidos(){
    const lista = $('#lista-mensajes');
    lista.find(`.recibido[data-id]`).each(function(){
        MarcarComoLeido($(this).attr('data-id'));
        ($(this).removeAttr('data-id'));
    });

}