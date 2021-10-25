const ObtenerElementoMensajeContacto = (foto, mensaje, fecha_envio) => `
    <li class="recibido">
        <img src="${foto}?w=37&h=37" alt="Contacto" class="no-seleccionable" />
        <div class="dir"></div>
        <div class="cont-msj"><p>${mensaje}</p></div>
        <div class="extra-mensaje no-seleccionable">
            <div class="extra">
                <span>${fecha_envio}</span>
            </div>
        </div>
    </li>`;

const ObtenerElementoMensajeEnviado = mensaje => {
    const msg = $(ObtenerElementoMensaje(mensaje));
    msg.find('.extra-mensaje').html('<div class="enviando"></div>');
    return msg;
};

const ObtenerElementoImgContacto = (foto, nombre, url, fecha_envio) => {
const msg = $(ObtenerElementoMensajeContacto(foto, "", fecha_envio));
msg.find('.cont-msj').addClass("contenedor-imagen-recibida").html(`<img src="${url}" class="imagen-enviada"  title="${nombre}">`);
return msg;
};

const ObtenerElementoImgEnviada = (nombre, url_data) => {
    const msg = ObtenerElementoImg(nombre, url_data, null, null);
    msg.find('.extra-mensaje').html('<div class="enviando"></div>');

    return msg;
};

const ObtenerElementoImg = (nombre, url, fecha_envio, estado) => {
    const msg = $(ObtenerElementoMensaje('', fecha_envio, estado));
    msg.find('.cont-msj').addClass('contenedor-imagen-enviada').html(`<img class="imagen-enviada" src="${url}" title="${nombre}">`);
    return msg;
}

/*
* Estados:
* 1- Enviado
* 2- Recibido
* 3- Leido
* */
const ObtenerElementoMensaje = (mensaje, fecha_envio, estado) => `
<li class="enviado">
            <img src="${ObtenerUrlImagen($('#profile-img'), 37, 37)}" alt="" class="no-seleccionable remitente"/>
            <div class="dir"></div>
            <div class="cont-msj"><p> ${mensaje}</p> </div>
            <div class="extra-mensaje no-seleccionable">
                ${fecha_envio !== undefined || estado !== undefined? ObtenerElementoExtraMensaje(fecha_envio, estado) : ''}
            </div>
    </li>`;
const ObtenerElementoMensajeAudio = (blob) => {
    const msg = $(ObtenerElementoMensajeEnviado(""));
    let audio =$('<audio>',{
        src: blob,
        type: "audio/mpeg",
        class: "mensaje-audio"}
        );
    let cont = $("<div>",  {
        class: "audio-enviado"
    }).append(ObtenerControlesAudio()).append(audio);
    msg.find(".cont-msj").removeClass("cont-msj").addClass("contenedor-audio-enviado").html(cont);
return msg;
}
function ObtenerControlesAudio(){
    const msg = $('<div class="boton-play-pause"><i class="far fa-play-circle"></i></div><div class="control-indicador"><div class="control-indicador-total"></div><div class="bola"></div></div><div class="control-tiempo-total">0:00</div>');
    return msg;
}

/*
* Estados:
* 1- Enviado
* 2- Recibido
* 3- Leido
* */
const ObtenerElementoExtraMensaje = (fecha_envio, estado) => {
    let html = fecha_envio !== undefined ? '<div class="extra"><span>' + fecha_envio + '</span>' : '';

    switch (estado) {
        case 1:
            return html + '<div class="extra icon"><span class="material-icons">done</span></div>';
        case 2:
            return html + '<div class="extra icon"><i class="far fa-check-circle"></i></div>';
        case 3:
            return html + '<div class="extra icon"><i class="fas fa-check-circle"></i></div>';
        default:
            return html;
    }
}


function MarcarComoLeido(idMsg, callback){
    $.ajax('/action/messages/markAsRead', {
        method: 'post', dataType: 'json', mimeType: 'application/json',
        data: {
            id: idMsg
        },
        success: callback
    });
}