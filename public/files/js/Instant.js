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
        const nombre = row.first_name + " " + row.last_name;

        //Si el mensaje es para el contacto de la actual conversación abierta en el chat.
        if (row['id'].toString() === $('#espacio-de-chat .messages').attr('data-usuario')) {
            const foto = ObtenerUrlImagen($('.contact-profile img'));
            const mensaje = $(ObtenerElementoMensajeContacto(foto, row.content, row.send_date));
            $('#lista-mensajes').append(mensaje);
            mensaje[0].scrollIntoView();

            if (document.visibilityState && document.visibilityState !== "visible")
                NotifiacionesEscritorio(row['id'], nombre, row.content, foto);
        }else{
            NotifiacionesEscritorio(row['id'], nombre, row.content, null);
        }
    })
}

function MostrarMensajeEnEspacioDeChat() {

}