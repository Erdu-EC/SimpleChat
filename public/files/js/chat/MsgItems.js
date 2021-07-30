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