$(document).on("keydown", "#espacio-de-escritura", function (e) {
    if (e.which == 13) {
        EnviarMensaje();
        return false;
    }
});

$(document).on("keyup change", "#espacio-de-escritura", function () {
    message = $("#espacio-de-escritura .wrap input").val();
    if ($.trim(message) === '') {
        $("#btn-enviar-mensaje").removeClass("activar");
        $("#buscar-contacto .borrar").remove();

    } else {
        $("#btn-enviar-mensaje").addClass("activar");
        $("#cuadro-busqueda-usuario").after(' <div class="borrar"><span class="material-icons"> close</span></div>');

    }
});

$(document).on('click', '#mensaje-invitacion button', function () {
    const boton_si = $('#mensaje-invitacion button:first');
    const boton_no = $('#mensaje-invitacion button:last');

    $.ajax('/action/invitation/accept', {
        method: 'post', dataType: 'json', mimeType: 'application/json',
        data: {
            contact: $('#espacio-de-chat > div').attr('data-usuario'),
            accept: $(this).is(boton_si)
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
            if (json)
                $('#mensaje-invitacion').remove();
            else {
                boton_si.attr('disabled', null);
                boton_no.attr('disabled', null);
            }
        }
    });
});

$(document).on('click', '#espacio-de-escritura .wrap button', function () {
    EnviarMensaje()
});

function EnviarMensaje() {
    const textarea = $('#espacio-de-escritura .wrap input');
    const texto = textarea.val().trim();
    textarea.val('');
    $("#btn-enviar-mensaje").removeClass("activar");
    if (texto !== '') {
        const mensaje = $(ObtenerElementoMensaje(texto));

        $.ajax('/action/messages/send', {
            method: 'post', dataType: 'json', mimeType: 'application/json',
            data: {
                contact: $('#espacio-de-chat > div').attr('data-usuario'),
                text: texto
            },
            beforeSend: () => $('#espacio-de-chat .messages #lista-mensajes').append(mensaje),
            error: () => {
                setTimeout(function () {
                    mensaje.find('.extra-mensaje').empty().append(' <div class="extra"><i class="far fa-clock"></i></div>');
                }, 150)
            },
            success: function (json) {
                if (json) {
                    var hora_envio = ObtenerHoraMensaje (new Date());
                    mensaje.find('.extra-mensaje').empty().append('<div class="extra"><span>' + hora_envio + '</span></div> <div class="extra icon"><span class="material-icons">done</span></div> ');

                    /*Estados de un mensaje enviado
                 enviado: <div class="extra icon"><span class="material-icons">done</span></div>
                 entregado:<div class="extra icon"><i class="far fa-check-circle"></i></div>
                 visto: <div class="extra icon"><i class="fas fa-check-circle"></i></div>

                    * */

                } else
                    mensaje.find('.popover-header').text("Error al enviar.");
            }
        });
    }

    $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
}

//Agregar contacto
function CargarEspacioDeChat() {
    const nombre_usuario = $(this).attr('data-usuario');

    $('#espacio-de-chat').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).load(`/Chats/${nombre_usuario}`, function (){
        //Eliminar globo contador de mensajes no leidos.
        $(`#lista-conversaciones .contact > div[data-usuario=${nombre_usuario}] .num-msj-pendientes.online`).remove();

        //Actualizar total de conversaciones no leidas.
        ActualizarTotalDeConversacionesNoLeidas();

        //Actualizar panel de información de contacto, si este esta abierto.
        if ($('#panelInfoContacto').hasClass('mostrar'))
            ActualizarInfoContacto();
    });
}

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

const ObtenerElementoMensaje = mensaje => `
<li class="enviado">
            <img src="/files/profile/mikeross.png?w=40&h=40" alt="" />
            <div class="dir"></div>
            <div class="cont-msj"><p> ${mensaje}</p> </div>
            <div class="extra-mensaje">
                                <div class="enviando">
                                </div>
                               
            </div>
    </li>`;



function ObtenerHoraMensaje( hora) {
    var act = new Date(hora);
    var hora_envio='';
    if (act.getHours() < 13 ) {
        hora_envio += act.getHours() + ':';
        hora_envio += (act.getMinutes()<10?'0':'') + act.getMinutes();
        hora_envio += ' a.m.';
    }
    else{

        hora_envio += (act.getHours() - 12) + ':';
        hora_envio += (act.getMinutes()<10?'0':'') + act.getMinutes();
        hora_envio += ' p.m.';
    }
console.log(hora_envio);

return hora_envio;
}
function ObtenerFecha(fecha){
    if(fecha==null)
        return "----";
    var fecha_rec= new Date(fecha);
var meses = ["En.", "Febr.", "Mzo.", "Abr.","May.","Jun.", "Jul.", "Agto.","Sept.","Oct.","Nov.","Dic."];
    return fecha_rec.getDate() + " " + meses[fecha_rec.getMonth()] + " " + fecha_rec.getUTCFullYear();
}