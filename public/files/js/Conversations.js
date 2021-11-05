
//se cargan las conversaciones con los contactos agregados
$(document).ready(cargar_conversaciones);
$(document).on('click', '.elemento-conversacion', CargarEspacioDeChat);

function cargar_conversaciones() {
    const alerta = $('#alerta-conversaciones').html('');
    const lista_conversaciones = $('#lista-conversaciones').html('');

    $.ajax('/action/conversations', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        beforeSend: () => lista_conversaciones.html(ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')),
        error: () => alerta.text('No fue posible cargar las conversaciones.'),
        success: function (json) {
            if (json === null)
                alerta.text('No fue posible cargar las conversaciones.');
            else if (json.length === 0) {
                lista_conversaciones.html('');
                alerta.html('No tienes ninguna conversación.<br/><br/>¡Busca un contacto y haz una!');
            } else {
                alerta.html('Tienes ' + json.length + ' conversacion(es)<br/><br/><small class="text-secondary">¡Busca un contacto y haz más!</small>')

                lista_conversaciones.html('');
                json.forEach((registro) => {
                    var estado='';
                    switch(registro.state){
                        case 'I':
                            estado='inactivo';
                            break;
                        case 'A':
                            estado= 'online'
                            break;
                    }
                    if(registro.msg_img !== null){
                        registro.msg_text = '<span class="material-icons icon-indicador">image</span> Archivo de imagen';

                    }
                    else if(registro.msg_audio !== null){
                        registro.msg_text= '<span class="material-icons icon-indicador">mic</span> Archivo de audio';
                    }
                    else{
                        registro.msg_text =  SanearTexto(registro.msg_text);
                    }

                    var msg = $('<li>', {
                        class: 'contact',
                        html: ObtenerElementoConversacion(registro.contact, registro.firstname, registro.lastname, registro.profile,estado, registro.hasInvitation, registro.msg_text, registro.isMyMessage, registro.msg_send,registro.msg_rcv, registro.msg_read),
                    }).appendTo(lista_conversaciones);


                });
            }
            $("#sidepanel").focus();
        }
    });
    //se inicia el temporizador a la espera de actualizaciones de estados de contactos
    temporizador = window.setTimeout(
        () => {ContactosInactivos();
        }, 180000);
}

const ObtenerElementoConversacion = (usuario_id, nombres, apellidos, foto_perfil, estado,hay_invitacion, contenido, enviado, ult_msj, hora_recibido, hora_leido) =>

    `<div class="wrap elemento-conversacion" data-usuario="${usuario_id}">
<div class="conversacion-perfil">
<span class="contact-status ${estado}"></span>
        <img src="${foto_perfil}?w=40&h=40" alt="" />
</div>
        
        <div class="meta">
            <p class="name">${nombres} ${apellidos}</p>
            <div class="preview">${        
        (contenido === null && hay_invitacion) ?
            '<i>Tienes una invitacion.</i>' :
            (contenido === null ) ?
                '<i>Has rechazado una invitación.</i>' :
                (enviado) ? IndicadorEstadoMensaje(hora_recibido,hora_leido )+ contenido : contenido

    }
            </div>
        </div>
        <div class="msj-pendientes ">
            <div class="hora-ult-mesj">
                ${Fecha_hora_ultima_Mensaje(ult_msj)}
            </div>
            ${(enviado) ? '': EstadosMensajesPendientes(hora_leido, hora_recibido)}
        </div>
    </div>`;

function EstadosMensajesPendientes(hora_leido, hora_recibido){

    if(hora_leido === null)
    {
        let hora_actual = new Date();
        let hora_recepcion = new Date(hora_recibido);
        if( (Math.floor((hora_actual- hora_recepcion)/3600000)) > 1 ){
            return '<div class="num-msj-pendientes anterior"><span>1</span></div>';
        }
        return '<div class="num-msj-pendientes online"><span>1</span></div>';
    }
    return '';
}

//<div class="num-msj-pendientes anterior"><span>n</span></div> -> para notificaciones vistas

const obtener_elemento_msg_pendientes = (num) => '<div class="num-msj-pendientes online"><span>' + num + '</span></div>';

function IndicadorEstadoMensaje(hora_recibido, hora_leido){
    var indicador ='';
    if(hora_leido === null || hora_leido === ""){
        if(hora_recibido === null || hora_recibido === ""){
            indicador= '<span class="material-icons icon-indicador">done</span>';
        }
        else{
            indicador='<i class="far fa-check-circle icon-indicador"></i>';
        }
    }else{
        indicador='<i class="fas fa-check-circle icon-indicador"></i>';
    }
    return indicador;
}
