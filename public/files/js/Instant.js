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
            if (ev.data['messages'].length > 0){
                TratarMensajes(ev.data['messages']);
            }

            //Si hay invitaciones no recibidas.
            if (ev.data['invitations'].length > 0){
                TratarInvitaciones(ev.data['invitations']);
            }

            //Si hay cambios de estado no recibidos.
            if (ev.data['msg_states'].length > 0)
                TratarCambiosDeEstadosEnMensajes(ev.data['msg_states']);

            //Si hay cambios en contactos activos.
            if (ev.data['contact_active'].length > 0) {
                TratarCambiosDeEstadosEnContactos(ev.data['contact_active']);
            }
        }
    }
});

function TratarMensajes(mensajes) {
    mensajes.forEach(row => {
        //Enviar leido al servidor.
        MarcarComoRecibido(row.id_msg, null);

        //Obteniendo elementos.
        const lista_conversaciones = $('#lista-conversaciones');
        let elemento_contacto = lista_conversaciones.find(`.contact > div[data-usuario=${row.user_name}]`);
        const nombre = row.first_name + " " + row.last_name;
        var texto_saneado = SanearTexto(row.text);

        //Si no existe conversacion, agregarla.
        if (elemento_contacto.length === 0) {
            elemento_contacto = $('<li>', {
                class: 'contact',
                html: ObtenerElementoConversacion(row.user_name, row.first_name, row.last_name, row.profile, "online", null, texto_saneado, row.send_date, row.send_date, row.rcv_date, row.read_date)
            });
            elemento_contacto.prependTo(lista_conversaciones);
        }

        //Si el mensaje es para el contacto de la actual conversación abierta en el chat.
        if (row.user_name === $('#lista-conversaciones li.active .elemento-conversacion').attr("data-usuario")) {
            MostrarMensajeEnEspacioDeChat(nombre, row);
        }
        else {

            if (row.img !== null) {
                row.text = nombre + " te ha enviado una imagen.";
            } else if (row.audio !== null) {
                row.text = nombre + " te ha enviado un audio.";
             }
            MensajeNuevo(row.id, nombre, row.text, row.profile);

            // Agregar mensaje a la lista de mensajes en buffer
            AgregarMensajesABufferChat(row);

            //Contar mensajes no leidos.
            const msg_pendientes = elemento_contacto.find('.num-msj-pendientes').removeClass('anterior').addClass('online').find('span');

            if (msg_pendientes.length === 0) {
                elemento_contacto.find('.msj-pendientes').append(obtener_elemento_msg_pendientes(1));
            } else
                msg_pendientes.text(parseInt(msg_pendientes.text()) + 1);
        }

        //Mover conversación hacia arriba en la lista de conversaciónes.
        elemento_contacto.parent().prependTo(lista_conversaciones);

        //Mostrar vista previa del mensaje en lista de conversaciones.
        elemento_contacto.find('.hora-ult-mesj').text(Fecha_hora_ultima_Mensaje(row.send_date));

        if (row.img !== null) {
            elemento_contacto.find('.preview').html(`<span class="material-icons icon-indicador">image</span> Archivo de imagen`);
        } else if (row.audio !== null) {
            elemento_contacto.find('.preview').html(`<span class="material-icons icon-indicador">mic</span> Archivo de audio`);
        } else {
            elemento_contacto.find('.preview').html(row.text);
        }
        //Actualizar total de conversaciones no leidas.
        ActualizarTotalDeConversacionesNoLeidas();
    })
}

function MostrarMensajeEnEspacioDeChat(nombre, datos) {
    let mensaje;

    //Enviar leido al servidor.
    MarcarComoLeido(datos.id_msg, null);

    if (datos.img !== null) {
        datos.text = nombre + " te ha enviado una imagen.";
        mensaje = ObtenerElementoImgContacto(datos.profile, datos.img.split('\\').pop().split('/').pop(), '/files/chat/'+datos.img, ObtenerHora(datos.send_date));
        AgregarImagenAGaleria(datos.img);
    }
   else if (datos.audio !== null)
   {
       datos.text = nombre + " te ha enviado un audio.";
       mensaje = ObtenerElementoMensajeAudioRecibido('/files/audio/'+datos.audio, datos.profile,  ObtenerHora(datos.send_date),datos.id_msg);
    }
   else {
        mensaje = $(ObtenerElementoMensajeContacto(datos.profile, datos.text, ObtenerHora(datos.send_date)));
    }
    mensaje.attr("data-timestamp", ObtenerTimeStamp(datos.send_date) );
    AgregarMensajeEnEspacioDeChat(mensaje, datos.send_date);
    mensaje[0].scrollIntoView();

    NotificacionesEscritorio(datos.id, nombre, datos.text, datos.profile);
}

function ActualizarTotalDeConversacionesNoLeidas() {
    const elementos_msg_pendientes = $(`#lista-conversaciones .contact .num-msj-pendientes`);
    const icono_contador = $('#icon-indicador-mensaje span');

    if (elementos_msg_pendientes.length === 0){
        icono_contador.parent().hide();
        document.title = `SimpleChat: Inicio`;
    }
    else{
        icono_contador.text(elementos_msg_pendientes.length).parent().show();
        document.title = `(${elementos_msg_pendientes.length}) SimpleChat: Inicio`;
    }
}


function TratarInvitaciones(inv_list) {
    const lista_conversaciones = $('#lista-conversaciones');
    const espacio_chat = $('#espacio-de-chat .messages');

    inv_list.forEach(row => {
        const elemento = lista_conversaciones.find(`.contact > div[data-usuario=${row.nick}]`);
        const elemento_html = ObtenerElementoConversacion(row.nick, row.first_name, row.last_name, row.profile, "online", true, null, row.send_date, row.send_date, row.rcv_date, null);

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

        //Si la conversacion esta abierta, mostrar modal de invitacion.
        if (espacio_chat.attr('data-nick') === row.nick && espacio_chat.is(':visible') )
        {
            if(espacio_chat.find("#mensaje-invitacion").length === 0){$(ObtenerModalDeInvitacion(row.first_name + " " + row.last_name)).prependTo(espacio_chat);}
        NotificacionesEscritorio(row.nick, row.first_name + " " + row.last_name, $(elemento_html).find('.preview').text(), row.profile);}
        else{

            if (buffer_chat.has(row.nick)){

                let chat_en_buffer = $("<div></div>").html(buffer_chat.get(row.nick));
                if(chat_en_buffer.find("#mensaje-invitacion").length === 0){
                    chat_en_buffer.find(".messages").before($(ObtenerModalDeInvitacion(row.first_name + " " + row.last_name)));
                    buffer_chat.set(row.nick,chat_en_buffer.html() );

                    //Si no existe notificación en espacio-de-chat, se crea una notificacion de escritorio
                    NotificacionesEscritorio(row.nick, row.first_name + " " + row.last_name, $(elemento_html).find('.preview').text(), row.profile);
                }

            }
        }




    })
}

function TratarCambiosDeEstadosEnMensajes(datos) {
    const lista = $('#lista-mensajes');

    datos.forEach(row => {
        const extra_mensaje = lista.find(`.enviado[data-id=${row.id_msg}] .extra-mensaje`);
        const estado = row.read_date != null ? 3 : 2;

        extra_mensaje.html(ObtenerElementoExtraMensaje(extra_mensaje.find('> .extra > span:first-child').text(), estado));

        //Actualizar estado de mensajes anteriores
        let elemento = extra_mensaje.parent();
            elemento.prevAll(".enviado[data-id]").find(".extra-mensaje").html(ObtenerElementoExtraMensaje(extra_mensaje.find('> .extra > span:first-child').text(), estado));

        //Actualizar conversación.
        let elemento_contacto = $(`#lista-conversaciones .contact > div[data-usuario=${row.destination}] .preview`);
        elemento_contacto.find(' > :first-child').remove();
        $(IndicadorEstadoMensaje(row.receive_date, row.read_date)).prependTo(elemento_contacto);

        //Si el mensaje ya ha sido leido eliminar id.
        if (estado === 3) extra_mensaje.parent().attr('data-id', null);
    });
}


function AgregarMensajesABufferChat(datos) {
    if (buffer_chat.has(datos.user_name)) {
        let mensaje;
        if (datos.img !== null) {
            mensaje = ObtenerElementoImgContacto(datos.profile, datos.img.split('\\').pop().split('/').pop(), datos.img, ObtenerHora(datos.send_date));
        }
        else if(datos.audio !== null){
            mensaje = ObtenerElementoMensajeAudioRecibido('/files/audio/'+datos.audio, datos.profile,  ObtenerHora(datos.send_date),datos.id_msg);
        }
        else {
            mensaje = $(ObtenerElementoMensajeContacto(datos.profile, datos.text, ObtenerHora(datos.send_date)));
        }
        mensaje.attr("data-id", datos.id_msg).attr("data-timestamp", ObtenerTimeStamp(datos.send_date) );
        let espacio_chat = $(buffer_chat.get(datos.user_name));
        let lista = espacio_chat.find("#lista-mensajes");
        //Se busca la etiqueta que separa los mensajes nuevos, si no existe se agrega
        let marcador= lista.find("li.marcador > .marcador-pendientes");
        if(marcador.length === 0 ){
            lista.append(ObtenerSeparadorMensajesPendientes);
        }
        //Al final se agregan los mensajes al objeto en buffer, y se guardan los  cambios
        lista.append(mensaje);
        buffer_chat.set(datos.user_name, espacio_chat);

    }
}

function TratarCambiosDeEstadosEnMensajesRecibidos() {
    const lista = $('#lista-mensajes');
    lista.find(`.recibido[data-id]`).each(function () {
        if (MarcarComoLeido($(this).attr('data-id'), function () {
                       return true;
        })) {
            $(this).removeAttr('data-id');
        }
    });
}

let temporizador;

function TratarCambiosDeEstadosEnContactos(contactos){
    clearTimeout(temporizador);
    ContactosInactivos();
    let usuario_chat = $("#espacio-de-chat .messages");

contactos.forEach(item => {
var elemento_conversacion = $('#lista-conversaciones .contact .elemento-conversacion[data-usuario='+item.user_name+']');
if(elemento_conversacion.length !== 0){
    elemento_conversacion.find(".contact-status").removeClass("inactivo").addClass("online");
}
if(item.user_name === usuario_chat.attr("data-nick")){
usuario_chat.siblings(".contact-profile").find(".ult-conex").text("Activo");
}

});
temporizador = window.setTimeout(
            () => {ContactosInactivos();
            }, 150000);

}

function ContactosInactivos(){
    let usuario_chat = $("#espacio-de-chat .messages");
    usuario_chat.siblings(".contact-profile").find(".ult-conex").text("Inactivo");
    $("#lista-conversaciones .contact .elemento-conversacion").each(function () {
        $(this).find(".contact-status").removeClass("online").addClass("inactivo");
    })
}
function ActualizarEstadoContacto(nombre_usuario, estado){
    let estado_usuario="";
    let ult_conexion = "";
switch (estado) {
    case "A":
        estado_usuario="online";
        ult_conexion = "Activo";
        break;
    case "I":
        estado_usuario="inactivo";
        ult_conexion = "Inactivo";
        break;
}
$("#espacio-de-chat").find(".ult-conex").text(ult_conexion);
let contacto = $('#lista-conversaciones .contact .elemento-conversacion[data-usuario='+nombre_usuario+']');
if(contacto.length > 0){
    contacto.find(".contact-status").removeClass("inactivo online").addClass(estado_usuario);
}
}