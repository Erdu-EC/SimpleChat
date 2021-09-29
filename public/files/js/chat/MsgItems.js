const ObtenerElementoMensajeContacto = (foto, mensaje, fecha_envio) => `
    <li class="recibido">
        <img src="${foto}?w=40&h=40" alt="Contacto" class="no-seleccionable" width="37px" height="37px"/>
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

}

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
            <img src="${ObtenerUrlImagen($('#profile-img'), 40, 40)}" alt="" class="no-seleccionable"/>
            <div class="dir"></div>
            <div class="cont-msj"><p> ${mensaje}</p> </div>
            <div class="extra-mensaje no-seleccionable">
                ${fecha_envio !== undefined || estado !== undefined? ObtenerElementoExtraMensaje(fecha_envio, estado) : ''}
            </div>
    </li>`;

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
