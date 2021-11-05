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
                ${fecha_envio !== undefined || estado !== undefined ? ObtenerElementoExtraMensaje(fecha_envio, estado) : ''}
            </div>
    </li>`;

function ObtenerControlesAudio() {
    return $('<div class="boton-play-pause" id="' + Date.now() + '"><i class="far fa-play-circle"></i></div><div class="control-indicador"><div class="control-indicador-total"></div><div class="bola"></div></div><div class="control-tiempo-total">00:00</div>');
}

const ObtenerElementoMensajeAudio = (blob, duracion, fecha_envio, estado) => {
    const msg = $(ObtenerElementoMensaje("", fecha_envio, estado));
    let audio = $('<audio>', {
            src: blob,
            type: "audio/webm",
            class: "mensaje-audio"
        }
    ).attr('data-duration', duracion ?? 0);

    if (duracion === null){
        const metadata = document.createElement("audio");
        metadata.preload = "metadata";
        metadata.onloadend = ()=> {
            URL.revokeObjectURL(metadata.src);
            metadata.preload = 'none';
        }
        metadata.onloadedmetadata = () => {
            audio.attr('data-duration', metadata.duration*1000); //Duracion en segundos.
            msg.find('.control-tiempo-total').text(ObtenerSegundosComoTiempo(metadata.duration));
        }
        metadata.src = blob;
    }

    let cont = $("<div>", {
        class: "audio-enviado"
    }).append(ObtenerControlesAudio()).append(audio);
    msg.find(".cont-msj").removeClass("cont-msj").addClass("contenedor-audio-enviado no-seleccionable").html(cont);
    return msg;
}

const ObtenerElementoMensajeAudioEnviado = (blob, duracion) => {
    const msg = $(ObtenerElementoMensajeAudio(blob,duracion,Date.now(),null));
    msg.find('.extra-mensaje').html('<div class="enviando"></div>');
    return msg;
}

const ObtenerElementoMensajeAudioRecibido = (src, foto, fecha) => {
    const msg = $(ObtenerElementoMensajeContacto(foto,"",fecha));
    let audio = $(`<audio type='audio/webm' class="mensaje-audio" src='${src}' ></audio>`);

    audio[0].onloadedmetadata = function (){
        audio.attr('data-duration',audio[0].duration*1000 );
        msg.find(".control-tiempo-total").text(ObtenerSegundosComoTiempo(audio[0].duration));
    }
  let cont = $("<div>", {
        class: "audio-recibido"
    }).append(ObtenerControlesAudio()).append(audio);
    msg.find(".cont-msj").removeClass("cont-msj").addClass("contenedor-audio-recibido no-seleccionable").html(cont);
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


function MarcarComoLeido(idMsg, callback) {
    $.ajax('/action/messages/markAsRead', {
        method: 'post', dataType: 'json', mimeType: 'application/json',
        data: {
            id: idMsg
        },
        success: callback
    });
}