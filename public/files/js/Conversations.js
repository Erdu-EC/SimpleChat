//Funcion que se ejecuta al cargar la pagina web
//se cargan las conversaciones con los contactos agregados y no agregados
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
                    $('<li>', {
                        class: 'contact',
                        html: ObtenerElementoConversacion(registro[0], registro[1], registro[2], registro[3], registro[5], registro[7], registro[4], registro[8]),

                    }).appendTo(lista_conversaciones);
                });
            }
        }
    });
}

const ObtenerElementoConversacion = (usuario_id, nombres, apellidos, foto_perfil, hay_invitacion, contenido, enviado, ult_msj ) =>

`<div class="wrap elemento-conversacion" data-usuario="${usuario_id}">
<div class="conversacion-perfil">
<span class="contact-status online"></span>
        <img src="${foto_perfil}?w=100&h=100" alt="" />
</div>
        
        <div class="meta">
            <p class="name">${nombres} ${apellidos}</p>
            <div class="preview">${
        (contenido === null && hay_invitacion) ?
            '<i>Tienes una invitacion.</i>' :
            (contenido === null) ?
                '<i>Has rechazado una invitación.</i>' :
                (enviado) ? '<span class="material-icons">done</span>' + contenido : contenido
                
    }
            </div>
        </div>
        <div class="msj-pendientes ">
        <div class="hora-ult-mesj">
        ${Fecha_hora_ultima_Mensaje(ult_msj)}
</div>
        <div class="num-msj-pendientes online">
        
        <span>33</span>
        </div>
</div>
    </div>`;

//<div class="num-msj-pendientes anterior"><span>n</span></div> -> para notificaciones vistas


function Fecha_hora_ultima_Mensaje( fecha_mensaje) {
    var hoy = new Date();
    var fecha_msj = new Date(fecha_mensaje);
    var result= '';
    var diferencia = Math.trunc((hoy - fecha_msj)/(1000*60*60*24));
    if (diferencia < 1){
        var result= fecha_msj.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }).toLowerCase();

    }
    else  if (diferencia == 1){
        result= 'Ayer';
    }
    else if (diferencia < 7){
         dias = ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
                result= dias[fecha_msj.getDay()];
    }
    else if (hoy.getFullYear() == fecha_msj.getFullYear()){
        mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
       result = fecha_msj.getDate() +" de " + mes[fecha_msj.getMonth()];
    }
    else {
        result = fecha_msj.getDate() + "/" + fecha_msj.getMonth()+"/"+fecha_msj.getFullYear();
    }
return result;
}