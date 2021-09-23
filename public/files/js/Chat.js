$(document).on("keydown", "#contenido-mensaje", function (e) {
    if (e.which === 13) {
        EnviarMensaje();
        return false;
    }
});

$(document).on("keyup change", "#contenido-mensaje", function () {
    message = $("#contenido-mensaje").text();
    if ($.trim(message) === '') {
        $("#btn-enviar-mensaje").removeClass("activar");
        $("#buscar-contacto .borrar").remove();
        $("#frame .content .message-input .wrap .entrada-placeholder").show();

    } else {
       $("#btn-enviar-mensaje").addClass("activar");
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
            contact: $('#espacio-de-chat > div').attr('data-usuario'),
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
                }else
                    elemento.find('.preview').html('<i>Invitación rechazada</i>');

                $('#mensaje-invitacion').remove();
            } else {
                boton_si.attr('disabled', null);
                boton_no.attr('disabled', null);
            }
        }
    });
});

$(document).on('click', '#btn-enviar-mensaje', function () {
    EnviarMensaje()
});

function EnviarMensaje() {
    const textarea = $('#contenido-mensaje');
    const texto = textarea.text().trim();
    textarea.text('');
    $("#btn-enviar-mensaje").removeClass("activar");
    if (texto !== '') {
        const mensaje = $(ObtenerElementoMensajeEnviado(texto));
        const espacio_chat = $('#espacio-de-chat > div');

        $.ajax('/action/messages/send', {
            method: 'post', dataType: 'json', mimeType: 'application/json',
            data: {
                contact: espacio_chat.attr('data-usuario'),
                text: texto
            },
            beforeSend: () => AgregarMensajeEnEspacioDeChat(mensaje, new Date(Date.now()).toDateString()),
            error: () => {
                setTimeout(function () {
                    mensaje.find('.extra-mensaje').empty().append(' <div class="extra"><i class="far fa-clock"></i></div>');
                }, 150)
            },
            success: function (json) {
                if (json) {
                    const usuario_nick = espacio_chat.attr('data-nick').trim();

                    mensaje.find('.extra-mensaje').html(ObtenerElementoExtraMensaje(ObtenerHora(new Date()), 1));

                    //Actualizar item de conversación.
                    let elemento_conversacion = $(`#lista-conversaciones .elemento-conversacion[data-usuario=${usuario_nick}]`).parent();
                    elemento_conversacion.prependTo($('#lista-conversaciones'));
                    elemento_conversacion.find('.preview').html('<span class="material-icons icon-indicador">done</span>' + texto);
                    elemento_conversacion.find('.hora-ult-mesj').text(ObtenerHora(new Date(Date.now())));
                } else
                    mensaje.find('.popover-header').text("Error al enviar.");
            }
        });
    }

    $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
}

//Agregar contacto
function CargarEspacioDeChat() {
    var li_contenedor = $(this).parent();
    $("#sidepanel").addClass('no-visible-sm');
    if (li_contenedor.hasClass("active"))
        return; //evitamos recargar el espacio de chat en caso de que el elemento seleccionado sea el que está en uso

    $("#btn-cerrar-contacto").trigger("click");//provocamos el evento click en el boton de cerrar info de contacto (en caso de que se encuentre en pantalla)
    $('#lista-conversaciones li.active').removeClass('active');
    li_contenedor.addClass("active");

    const nombre_usuario = $(this).attr('data-usuario');
    const espacio_chat = $('#espacio-de-chat');

    espacio_chat.find('> *').hide();
    espacio_chat.append(`
        <div class="cargando d-flex h-100">
            ${ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')}
        </div>`);
    espacio_chat.show();

    $('#espacio-de-configuracion').hide();
    $('#espacio-temporal').remove();

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
                    const fecha_envio = ObtenerFecha(msg[3]);

                    if (fecha_anterior === '' || fecha_anterior !== fecha_envio) {
                        fecha_anterior = fecha_envio;
                        lista_mensajes.append(ObtenerSeparadorDeFechasEnChat(fecha_envio))
                    }

                    //Agregando mensaje.
                    if (msg[1] === json.id) {
                        lista_mensajes.append(ObtenerElementoMensajeContacto(json.profile_img, msg[6], ObtenerHora(msg[4])));
                    } else {
                        lista_mensajes.append(ObtenerElementoMensaje(msg[6], ObtenerHora(msg[3]),
                            msg[5] !== null ? 3 : msg[4] !== null ? 2 : 1));
                    }
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
            contact: $('#espacio-de-chat > div').attr('data-usuario')
        },
        beforeSend: () => {
            boton.attr('disabled', '').text('Agregando...');
        },
        error: () => {
            MostrarModal('Error', 'Ha ocurrido un error al intentar agregar al contacto, intentelo de nuevo.', function () {
                boton.attr('disabled', null).text('Agregar contacto');
            })
        },
        success: function (json) {
            if (json === true) {
                boton.remove();
                $('.opciones-contacto').remove();

                if (typeof actualizar_lista_contactos === 'function')
                    actualizar_lista_contactos();
            } else {
                MostrarModal('Error', 'Ha ocurrido un error al intentar agregar al contacto, intentelo de nuevo.', function () {
                    boton.attr('disabled', null).text('Agregar contacto');
                })
            }
        }
    });
});

