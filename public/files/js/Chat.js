$(document).on("keydown", "#contenido-mensaje", function (e) {
    if (e.which === 13) {
        EnviarMensaje();
        return false;
    }
});

$(document).on("keyup change", "#contenido-mensaje", function () {
    var message = $("#contenido-mensaje").text();
    if ($.trim(message) === '') {
        $("#btn-enviar-mensaje").removeClass("activar").addClass("modo-microfono").html('<i class="fas fa-microphone"></i>').attr("title","Grabar audio");
        $("#buscar-contacto .borrar").remove();
        $("#frame .content .message-input .wrap .entrada-placeholder").show();

    } else {
        $("#btn-enviar-mensaje").removeClass("modo-microfono").addClass("activar").html(`<i class="fas fa-paper-plane"></i>`).attr("title","Enviar mensaje");
        $("#cuadro-busqueda-usuario").after(' <div class="borrar"><span class="material-icons"> close</span></div>');
    }
});

$(document).on('click', '#mensaje-invitacion button', function () {
    const boton_si = $('#mensaje-invitacion #mensaje-invitacion-si');
    const boton_no = $('#mensaje-invitacion #mensaje-invitacion-no');
    const es_boton_si = $(this).is(boton_si);

    $.ajax('/action/invitation/accept', {
        method: 'post', dataType: 'json', mimeType: 'application/json',
        data: {
            contact: $('#espacio-de-chat > .messages').attr('data-usuario'),
            accept: es_boton_si
        },
        beforeSend: () => {
            boton_si.attr('disabled', '');
            boton_no.attr('disabled', '');
        },
        error: () => {
            boton_si.attr('disabled', null);
            boton_no.attr('disabled', null);
        },
        success: function (json) {
            if (json) {
                const elemento = $(`.elemento-conversacion[data-usuario=${$('#espacio-de-chat .messages').attr('data-nick')}]`);
                elemento.find('.hora-ult-mesj').text(Fecha_hora_ultima_Mensaje(new Date(Date.now())));

                if (es_boton_si) {
                    //Recargar conversación.
                    elemento.find('.preview').html('<i>Invitación aceptada</i>');
                    elemento.parent().removeClass('active');
                    elemento.click();
                } else
                    elemento.find('.preview').html('<i>Invitación rechazada</i>');

                $('#mensaje-invitacion').parent().remove();
            } else {
                boton_si.attr('disabled', null);
                boton_no.attr('disabled', null);
            }
        }
    });
});

$(document).on('click', '#btn-enviar-mensaje', function () {
    if($(this).hasClass("modo-microfono")){
      GrabarAudio();
        AgregarControlesGrabando();
    }else{
        EnviarMensaje();
    }

});

let grabacion = null;
let track;

function GrabarAudio() {

    const soporte = navigator.mediaDevices.getUserMedia;

    if(!soporte){
        swal({text:"La versión de tu navegador no soporta acceso al micrófono.", button:"Ok", icon:"/files/icon/not-microphone.png?w=50",  dangerMode: true,});
    }else {
        if (grabacion) return;
//Iniciamos la grabacion
        navigator.mediaDevices.getUserMedia({audio: { audioBitsPerSecond : 192000 ,audioBitrateMode:'constant' } })
            .then(  stream => {
                const fragmentosDeAudio = [];
                    // Comenzar a grabar con el stream
                    grabacion = new MediaRecorder(stream);
                    grabacion.start(1000);
                    Contador();
                    //Agregar fragmentos al arreglo cuando haya datos
                    grabacion.addEventListener("dataavailable", e => {
                        fragmentosDeAudio.push(e.data);
                    });

                    // Evento que se ejecuta al detener grabacion
                    grabacion.addEventListener("stop", () => {
                        stream.getTracks().forEach(track => track.stop());
                        track = new Blob(fragmentosDeAudio.slice(), { type: 'audio/webm' });
                        grabacion = null;
                    });
                }
            )
            .catch(e => {
                swal({text:"Error al intentar acceder al micrófono. Verifique si se ha concedido el permiso.", button:"Ok", icon:"/files/icon/not-microphone.png?w=50",  dangerMode: true,});
            });
    }

};




function EnviarMensaje() {
    const textarea = $('#contenido-mensaje');
    var texto = $.trim(textarea.text());
    var texto_org = texto;
    texto = SanearTexto(texto);
    textarea.html('');

    $("#btn-enviar-mensaje").removeClass("activar").addClass("modo-microfono").html('<i class="fas fa-microphone"></i>').attr("title","Grabar audio");

    if (texto !== '') {
        const mensaje = $(ObtenerElementoMensajeEnviado(texto));
        const espacio_chat = $('#espacio-de-chat > .messages');

        $.ajax('/action/messages/send', {
            method: 'post', dataType: 'json', mimeType: 'application/json',
            data: {
                contact: espacio_chat.attr('data-usuario'),
                text: texto_org
            },
            beforeSend: () => AgregarMensajeEnEspacioDeChat(mensaje, new Date(Date.now()).toDateString()),
            error: () => {
                setTimeout(function () {
                    mensaje.find('.extra-mensaje').empty().append(' <div class="extra"><i class="far fa-clock"></i></div>');
                }, 150)
            },
            success: function (json) {
                if (json[0]) {
                    const usuario_nick = espacio_chat.attr('data-nick').trim();

                    //Agregando id y estado al mensaje enviado.
                    mensaje.attr('data-id', json[1]);
                    mensaje.find('.extra-mensaje').html(ObtenerElementoExtraMensaje(ObtenerHora(new Date()), 1));

                    //Actualizar item de conversación.
                    let elemento_conversacion = $(`#lista-conversaciones .elemento-conversacion[data-usuario=${usuario_nick}]`).parent();

                    //Si no existe conversacion, agregarla.
                    if (elemento_conversacion.length === 0) {
                        let estado = $("#espacio-de-chat").find(".ult-conex").text();
                        switch (estado){
                            case 'Activo':
                                estado= "online";
                                break;
                            case 'Inactivo':
                                estado= "inactivo";
                                break;
                        }
                        elemento_conversacion = $('<li>', {
                            class: 'contact active',
                            html: ObtenerElementoConversacion(usuario_nick, espacio_chat.parent().find('.nombre-chat').text(), '', espacio_chat.parent().find('.img-contacto').attr('src').split("?")[0], estado, null, texto, new Date(), new Date(), null, null)

                        });
                    }

                    elemento_conversacion.prependTo($('#lista-conversaciones'));
                    elemento_conversacion.find('.preview').html('<span class="material-icons icon-indicador">done</span>' + texto);
                    elemento_conversacion.find('.hora-ult-mesj').text(ObtenerHora(new Date(Date.now())));
                    textarea.focus();
                    $("#frame .content .message-input .wrap .entrada-placeholder").show();
                } else
                    mensaje.find('.popover-header').text("Error al enviar.");
            }
        });
    }

    $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
    $("#contenido-mensaje").focus();
}

//Agregar contacto
function CargarEspacioDeChat() {
    var li_contenedor = $(this).parent();
    $("#sidepanel").addClass('no-visible-sm');
    if($(this).hasClass("elemento-conversacion")){
        $("#mi-perfil-sidepanel").removeClass("no-visible");
    }
    if (li_contenedor.hasClass("active"))
        return; //evitamos recargar el espacio de chat en caso de que el elemento seleccionado sea el que está en uso

    //provocamos el evento click en el boton de cerrar info de contacto (en caso de que se encuentre en pantalla)
    $("#btn-cerrar-contacto").trigger("click");

    var usr_ant = $('#lista-conversaciones li.active .elemento-conversacion').attr("data-usuario");

    $('#lista-conversaciones li.active').removeClass('active');
    const nombre_usuario = $(this).attr('data-usuario');
    const espacio_chat = $('#espacio-de-chat');

    let m= $('#lista-conversaciones li .elemento-conversacion[data-usuario="'+nombre_usuario+'"]').parent().addClass("active");
    //Buffer de conversaciones
    if( m !== undefined){
        if(Buffer_Conversaciones(usr_ant, nombre_usuario) ){
            return;
        }
    }
    $("#contenido-mensaje").empty();
    $("#frame .content .message-input .wrap .entrada-placeholder").show();
    espacio_chat.find('> *').hide();
    espacio_chat.append(`
        <div class="cargando d-flex h-100">
            ${ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')}
        </div>`);
    espacio_chat.show();

    $('#espacio-de-configuracion').hide();
    $('#espacio-temporal').remove();
    $("#espacio-de-chat").focus();

    $.ajax(`/Chats/${nombre_usuario}`, {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        beforeSend: () => {
        },
        error: () => {
        },
        success: function (json) {
            if (json !== false) {
                const contenedor_datos = espacio_chat.find('.contact-profile');
                const lista_mensajes = $('#lista-mensajes').html('');

                //Estableciendo datos.
                espacio_chat.find('.messages').attr('data-usuario', json.id).attr('data-nick', nombre_usuario);
                contenedor_datos.find('img').attr('src', null).attr('src', json.profile_img + '?w=40&h=40');
                contenedor_datos.find('.nombre-chat').text(json.full_name);
                contenedor_datos.find('.ult-conex').text(json.state);

                if (json.is_contact)
                    contenedor_datos.find('.opciones-contacto').hide();
                else
                    contenedor_datos.find('.opciones-contacto').show();

                if (json.has_invitation)
                    lista_mensajes.before(ObtenerModalDeInvitacion(json.full_name));
                else
                    espacio_chat.find('.messages .notificacion').remove();

                //Mostrando mensajes.
                let fecha_anterior = '';
                json.messages.forEach(msg => {
                    //Estableciendo fecha del mensaje.
                    const fecha_envio = ObtenerFecha(msg.date_send);

                    msg.text = SanearTexto(msg.text);
                    if (fecha_anterior === '' || fecha_anterior !== fecha_envio) {
                        fecha_anterior = fecha_envio;
                        lista_mensajes.append(ObtenerSeparadorDeFechasEnChat(fecha_envio))
                    }

                    //Agregando mensaje.
                    let mensaje;
                    if (msg.origin === json.id) {
                        if (msg.img !== null)
                            mensaje = ObtenerElementoImgContacto(json.profile_img, msg.img.split('\\').pop().split('/').pop(), msg.img, ObtenerHora(msg.date_send))
                        else if (msg.audio !== null)
                            mensaje = ObtenerElementoMensajeAudioRecibido(msg.audio, json.profile_img,ObtenerHora(msg.date_send));
                        else
                            mensaje = ObtenerElementoMensajeContacto(json.profile_img, msg.text, ObtenerHora(msg.date_send));
                    } else {
                        if (msg.img !== null)
                            mensaje = ObtenerElementoImg(msg.img.split('\\').pop().split('/').pop(), msg.img, ObtenerHora(msg.date_send),
                                msg.date_read !== null ? 3 : msg.date_reception !== null ? 2 : 1);
                        else if (msg.audio !== null)
                            mensaje = ObtenerElementoMensajeAudio(msg.audio, null,  ObtenerHora(msg.date_send),
                                msg.date_read !== null ? 3 : msg.date_reception !== null ? 2 : 1);
                        else
                            mensaje = ObtenerElementoMensaje(msg.text, ObtenerHora(msg.date_send),
                                msg.date_read !== null ? 3 : msg.date_reception !== null ? 2 : 1);
                    }

                    lista_mensajes.append($(mensaje).attr('data-id', msg.id));
                });

                //Mostrar contenedor.
                espacio_chat.find('.cargando').remove();
                espacio_chat.find('> *').show();
                espacio_chat.show();

                //Bajar scroll.
                espacio_chat.find('.messages').scrollTop(espacio_chat.find('.messages').prop("scrollHeight"));

                //Eliminar globo contador de mensajes no leidos.
                $(`#lista-conversaciones .contact > div[data-usuario=${nombre_usuario}] .num-msj-pendientes.online`).remove();

                //Actualizar total de conversaciones no leidas.
                ActualizarTotalDeConversacionesNoLeidas();

                //Actualizar panel de información de contacto, si este esta abierto.
                ActualizarInfoContacto();

            } else {
                console.log('Error al obtener mensajes.');
            }
        }
    });

}

function AgregarMensajeEnEspacioDeChat(item_msg, fecha_msg) {
    const lista_msg = $('#lista-mensajes');
    const fecha = ObtenerFecha(fecha_msg);

    if (lista_msg.find(`.marcador-fecha:contains(${fecha})`).length === 0)
        lista_msg.append(ObtenerSeparadorDeFechasEnChat(fecha));

    lista_msg.append(item_msg);
}

const ObtenerSeparadorDeFechasEnChat = fecha_envio => `<li class="marcador"><div class="marcador-fecha no-seleccionable">${fecha_envio}</div></li>`;

const ObtenerModalDeInvitacion = (nombre) => `
                            <div class="notificacion">
                                <div id="mensaje-invitacion" class="row border-bottom no-seleccionable">
                                <div class="cont-icon"><i class="fas fa-comments" id="icon-mensaje-invitacion"></i></div>
                                    <p><b>${nombre}</b> no está entre tus contactos y te ha enviado un mensaje. ¿Deseas recibir mensajes de ${nombre}?
                                    </p>
                                    <div class="botones">
                                        <button class="btn btn-si" id="mensaje-invitacion-si"><span class="material-icons">done</span>Si</button>
                                        <button class="btn btn-no" id="mensaje-invitacion-no"><span class="material-icons">close</span>No</button>
                                    </div>
                                </div>
                            </div>`;

$(document).on('click', '.btn-agregar-contacto', function () {
    const boton = $(this);

    $.ajax('/action/contacts/add', {
        method: 'post', dataType: 'json', mimeType: 'application/json',
        data: {
            contact: $('#espacio-de-chat > .messages').attr('data-usuario')
        },
        beforeSend: () => {
            boton.text('Agregando...');
        },
        error: () => {
            swal({
                icon: "error",
                text: "Ha ocurrido un error al intentar agregar al contacto. Por favor, verifique su conexión a Internet.",
                button: "Ok"
            });
            boton.html('<span class="material-icons">person_add</span> Agregar contacto');
        },
        success: function (json) {
            if (json === true) {
                boton.remove();
                $('#espacio-de-chat').find(".opciones-contacto").remove();

                if (typeof actualizar_lista_contactos === 'function')
                    actualizar_lista_contactos();
            } else {
                swal({
                    icon: "error",
                    text: "Ha ocurrido un error al intentar agregar al contacto, intentelo de nuevo.",
                    button: "Ok"
                });
                boton.html('<span class="material-icons">person_add</span> Agregar contacto');
            }
        }
    });
});

function SanearTexto(str) {
    if (str === null) return null;

    var caracteres = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
        '/': '&#x2F;',
        '`': '&#x60;',
        '=': '&#x3D;'
    };
    return String(str).replace(/[&<>"'`=\/]/g, function (s) {
        return caracteres[s];
    });
}


const buffer_chat = new Map();
function Buffer_Conversaciones(contacto_ant,contacto_act){

    if(! (contacto_ant === undefined || contacto_ant === "" )){
        buffer_chat.set(contacto_ant, $("#espacio-de-chat").clone().html());
    }

if(! (contacto_act === undefined || contacto_act === "" )) {
    if (buffer_chat.has(contacto_act)) {
        $("#espacio-de-chat").empty();
        let chat = $(buffer_chat.get(contacto_act));
        $("#espacio-de-chat").html(chat);
        $(`#lista-conversaciones .contact > div[data-usuario=${contacto_act}] .num-msj-pendientes.online`).remove();
        ActualizarConversacion();
        return true;
    }
}

    return false;
}

function ActualizarConversacion(){
    $("#espacio-de-chat .hacia-abajo").removeClass("visible");

    TratarCambiosDeEstadosEnMensajesRecibidos();
    ActualizarInfoContacto();
    ActualizarTotalDeConversacionesNoLeidas();
    $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
    $('#espacio-de-chat').show();
    $('#espacio-de-configuracion').hide();

}