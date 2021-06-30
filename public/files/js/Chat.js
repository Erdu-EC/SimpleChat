$(document).on('click', '#mensaje-invitacion button', function (){
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
            else{
                boton_si.attr('disabled', null);
                boton_no.attr('disabled', null);
            }
        }
    });
})

$(document).on('click', '#espacio-de-escritura .wrap button', function () {
    const textarea = $('#espacio-de-escritura .wrap input');
    const texto = textarea.val().trim();
    textarea.val('');

    if (texto !== '') {
        const mensaje = $(ObtenerElementoMensaje(texto));

        $.ajax('/action/messages/send', {
            method: 'post', dataType: 'json', mimeType: 'application/json',
            data: {
                contact: $('#espacio-de-chat > div').attr('data-usuario'),
                text: texto
            },
            beforeSend: () => $('#espacio-de-chat .messages #lista-mensajes').append(mensaje),
            error: () => mensaje.find('.popover-header').text("Error al enviar."),
            success: function (json) {
                if (json)
                    setTimeout(function () {mensaje.find('.enviando').remove()} ,150);

                else
                    mensaje.find('.popover-header').text("Error al enviar.");
            }
        });
        $(".messages").animate({ scrollTop: $('.messages').prop("scrollHeight")}, 300);
    }

})

function CargarEspacioDeChat(){
    $('#espacio-de-chat').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).load(`/Chats/${$(this).attr('data-usuario')}`);
    //Se elimina la imagen de bienvenida
    $("#espacio-de-chat .temporal").remove();
    //se muestra el div de mensajes
    $("#espacio-de-chat .messages").show();
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
            MostrarModal('Error', 'Ha ocurrido un error al intentar agregar al contacto, intentelo de nuevo.', function (){
                boton.attr('disabled', null).text('Agregar contacto');
            })
        },
        success: function (json) {
            if (json === true) {
                boton.remove();
                $('#mensaje-invitacion').remove();

                if (typeof actualizar_lista_contactos === 'function')
                    actualizar_lista_contactos();
            } else{
                MostrarModal('Error', 'Ha ocurrido un error al intentar agregar al contacto, intentelo de nuevo.', function (){
                    boton.attr('disabled', null).text('Agregar contacto');
                })
            }
        }
    });
});

const ObtenerElementoMensaje = mensaje => `
<li class="enviado">
            <img src="/files/profile/mikeross.png?w=40&h=40" alt="" />
            <p> ${mensaje}</p>
            <div class="extra-mensaje">
                                <div class="enviando">
                                </div>
            </div>
    </li>`;

function ObtenerElementoMensajeContacto(mensaje) {

}