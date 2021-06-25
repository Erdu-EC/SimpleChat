/*--------------------------------------
* Eventos JS de animaciones para el index-chat
* --------------------------------------*/



$(document).on('click', '#espacio-de-escritura button', function () {
    const textarea = $('textarea');
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
            beforeSend: () => $('#espacio-de-chat .card-body').append(mensaje),
            error: () => mensaje.find('.popover-header').text("Error al enviar."),
            success: function (json) {
                if (json)
                    mensaje.find('.popover-header').remove();
                else
                    mensaje.find('.popover-header').text("Error al enviar.");
            }
        });
    }


    //console.log(text);
});

function CargarEspacioDeChat(){
    $('#espacio-de-chat').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).load(`/Chats/${$(this).attr('data-usuario')}`);
}

function AgregarContacto(obj, func){

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
        <div class="popover bs-popover-end" style="position: relative; max-width: none">
            <div class="popover-arrow" style="position: absolute; transform: translate(0px, 17px);"></div>
            <h3 class="popover-header">Enviando...</h3>
            <div class="popover-body">${mensaje}</div>
        </div>
    `;

function ObtenerElementoMensajeContacto(mensaje) {

}