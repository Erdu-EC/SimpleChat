$(document).ready(function () {
    if (window.Worker) {
        const chatWorker = new Worker('/files/js/Chat-bg.js');
        chatWorker.onmessage = ev => {
            //Si hay mensajes no leidos.
            if (ev.data['messages'].length > 0)
                TratarMensajes(ev.data['messages']);
        }
    }
});

function TratarMensajes(mensajes) {
    mensajes.forEach(row => {
        const elemento_contacto = $(`#lista-conversaciones .contact > div[data-usuario=${row.user_name}]`);
        const nombre = row.first_name + " " + row.last_name;

        //Si el mensaje es para el contacto de la actual conversación abierta en el chat.
        if (row.id.toString() === $('#espacio-de-chat .messages').attr('data-usuario'))
            MostrarMensajeEnEspacioDeChat(nombre, row)
        else{
            NotificacionesEscritorio(row.id, nombre, row.content, row.profile);

            //Contar mensajes no leidos.
            const msg_pendientes = elemento_contacto.find('.num-msj-pendientes.online span');

            if (msg_pendientes.length === 0){
                elemento_contacto.find('.msj-pendientes').append(obtener_elemento_msg_pendientes(1));
            }else
                msg_pendientes.text(parseInt(msg_pendientes.text()) + 1);
        }

        //Mover conversación hacia arriba en la lista de conversaciónes.
        elemento_contacto.parent().prependTo($('#lista-conversaciones'));

        //Mostrar vista previa del mensaje en lista de conversaciones.
        elemento_contacto.find('.hora-ult-mesj').text(Fecha_hora_ultima_Mensaje(row.send_date));
        elemento_contacto.find('.preview').text(row.content);

        //Actualizar total de conversaciones no leidas.
        ActualizarTotalDeConversacionesNoLeidas();
    })
}

function MostrarMensajeEnEspacioDeChat(nombre, datos) {
    const mensaje = $(ObtenerElementoMensajeContacto(datos.profile, datos.content, ObtenerHora(datos.send_date)));

    AgregarMensajeEnEspacioDeChat(mensaje, datos.send_date);
    mensaje[0].scrollIntoView();

    if (document.visibilityState && document.visibilityState !== "visible")
        NotificacionesEscritorio(datos.id, nombre, datos.content, datos.profile);
}

function ActualizarTotalDeConversacionesNoLeidas(){
    const elementos_msg_pendientes = $(`#lista-conversaciones .contact .num-msj-pendientes.online`);
    const icono_contador = $('#icon-indicador-mensaje span');

    if (elementos_msg_pendientes.length === 0)
        icono_contador.parent().hide();
    else
        icono_contador.text(elementos_msg_pendientes.length).parent().show();
}