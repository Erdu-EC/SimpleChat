$("#seccion-contactos").on("click", function() {
$("#sidepanelTodosContactos .titulo-cab h1").html("Contactos");
    Contactos();
    actualizar_lista_contactos();
});


$("#nuevo-chat").on("click", function() {
    $("#sidepanelTodosContactos .titulo-cab h1").html("Nuevo Chat");
    Contactos();
    actualizar_lista_contactos();
});
//agregar boton de borrar texto en cuadro de busqueda de contactos
$(document).on("keyup change", "#cuadro-busqueda-usuario",function () {
    message = $("#cuadro-busqueda-usuario").val();
    if ($.trim(message) == '') {
        $("#buscar-contacto .borrar").remove();
        $('#lista-contactos').show();
    }
    else{
        if (!$("#buscar-contacto .borrar").length){
            $("#cuadro-busqueda-usuario").after(' <div class="borrar"><span class="material-icons"> close</span></div>');
        }
    }
});

$(document).on("click",'#buscar-contacto .borrar', function () {
    $("#cuadro-busqueda-usuario").val("");
    $('#lista-contactos-buscar').empty();
    $('#lista-contactos').show();
    $("#buscar-contacto .borrar").remove();
});

///////
$(document).on('input', '#cuadro-busqueda-usuario', function () {
    //const alerta = $('#alerta-busqueda-usuario').html('');

    const lista_resultados = $('#lista-contactos-buscar').html('');
    var entrada = $("#cuadro-busqueda-usuario").val();

if ($.trim(entrada) == ''){
    $('#lista-contactos').show();
    return;
}
    $('#lista-contactos').hide();

    if ($(this).val().length > 3) {
        $.ajax('/action/users/search', {
            method: 'post', dataType: 'json', mimeType: 'application/json',
            data: {
                text: entrada
            },
           beforeSend: () => {},// console.log("Buscando..."),//alerta.text("Buscando..."),
            error: () => {}, //console.log( "No fue posible realizar la busqueda."),//alerta.text("No fue posible realizar la busqueda."),
            success: function (json) {
                if (json === null)
                {
                    //console.log("Se recibieron nulos");
                } // alerta.text('No fue posible realizar la busqueda.');
                else if (json.length === 0) {
                    //alerta.text('No hay coincidencias.');
                    //console.log("Se recibieron nulos");
                }
                else {
                   // console.log("Se se han recibido datos");
                   // alerta.text(`Se ha encontrado ${json.length} coincidencias.`);

                    json.forEach((registro) => {
                        $('<li>', {
                            class: 'item-contacto',
                            html: ObtenerElementoContactoBuscado(registro[0], registro[1], registro[2], registro[3]),
                        }).appendTo(lista_resultados);
                    });
                }
            }
        });
    }
});

$(document).on('click', '.elemento-contacto', CargarEspacioDeChat);



function actualizar_lista_contactos() {
   // const alerta = $('#alerta-lista-contactos').html('');


    const lista_contactos = $('#lista-contactos').html('');

    $.ajax('/action/users/contacts', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        beforeSend: () => lista_contactos.html(ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')),
        error: () => {},//alerta.text('No fue posible cargar la lista de contactos.'),
        success: function (json) {
            if (json === null){}
                //alerta.text('No fue posible cargar la lista de contactos.');
            else if (json.length === 0){
                lista_contactos.html('');
                //alerta.html('Tu lista de contactos esta vacia.<br/><br/>¡Busca nuevos contactos y agregalos!');
            }
            else {
               // alerta.html('Tienes ' + json.length + ' contacto(s)<br/><br/><small class="text-secondary">¡Busca nuevos contactos y agregalos!</small>')

                lista_contactos.html('')

                json.forEach((registro) => {
                    $('<li>', {
                        class: 'item-contacto',
                        html: ObtenerElementoContacto(registro[0], registro[1], registro[2], registro[3]),
                    }).appendTo(lista_contactos);
                });
            }
        }
    });
}

const ObtenerElementoContactoBuscado = (usuario, nombres, apellidos, esContacto) =>`
<div class="elemento-contacto " data-usuario="${usuario}">

                            <div class="img-perfil-contacto">
                                <img src="/files/profile/danielhardman.png?w=60&h=60" alt="" class="online"/>
                            </div>
                                <div class="cuerpo-perfil-contacto">
                                    <span class="nombre-contacto">${nombres} ${apellidos}</span>

                                    <div class="nombre-usuario">
                                        <span class="material-icons icon-usuario">person</span>
${usuario}
                                        </div>
                                </div>
                    </div>
`;


/*
<div class="card mb-0 shadow elemento-contacto" style="cursor: pointer;" data-usuario="${usuario}">
        <div class="row g-0">
            <div class="col-md-3 p-1">
                <img src="/files/profile/0_erdu.png" class="img-fluid" alt="profile">
            </div>
            <div class="col-md-9 align-self-center">
                <div class="card-body p-2">
                    <h6 class="card-title">${nombres} ${apellidos}</h6>
                    <p class="card-text flex-row" style="font-size: .8rem;">
                        <small class="text-muted">
                            ${(esContacto) ? '<i class="material-icons" style="vertical-align: middle">person</i><span>Mi contacto</span>' : ''}
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>



* */
const ObtenerElementoContacto = (usuario, nombres, apellidos, ultima_conexion) => `
<div class="elemento-contacto">

                            <div class="img-perfil-contacto">
                                <img src="/files/profile/danielhardman.png?w=60&h=60" alt="" class="online"/>
                            </div>
                                <div class="cuerpo-perfil-contacto">
                                    <span class="nombre-contacto">${nombres} ${apellidos}</span>

                                    <div class="nombre-usuario">
                                        <span class="material-icons icon-usuario">person</span>
${usuario}
                                        </div>
                                        <di class="ult-conexion-contacto">
                                        <i class="far fa-clock"></i>
${(ultima_conexion !== undefined) ? ObtenerTiempoUltimaConexion(ultima_conexion) : ''}
                                    </di>
                                </div>
                    </div>
`;

/*<div class="card mb-2 elemento-contacto" style="cursor: pointer;" data-usuario="${usuario}">
        <div class="row g-0">
            <div class="col-md-3 p-1">
                <img src="/files/profile/0_erdu.png" class="img-fluid" alt="Foto de perfil">
            </div>
            <div class="col-md-9 align-self-center">
                <div class="card-body p-2">
                    <h6 class="card-title">${nombres} ${apellidos}</h6>
                    <p class="card-text" style="font-size: .8rem;"><small class="text-muted">${(ultima_conexion !== undefined) ? ObtenerTiempoUltimaConexion(ultima_conexion) : ''}</small></p>
                </div>
            </div>
        </div>
    </div>*/

function ObtenerTiempoUltimaConexion(fecha_hora) {
    const fecha = new Date(fecha_hora);
    var fecha_actual= new Date();
    var ult_conex = 'últ. conex.';

    if (fecha_hora==null){
        return ult_conex= 'Inactivo';
    }

    if (fecha.getDate() == fecha_actual.getDate()){
        ult_conex += ' hoy'}
    else if (fecha_actual.getDate()-fecha.getDate() == 1 )
    {
        ult_conex += ' ayer'}
    else {
        ult_conex += ' ' + fecha.toLocaleDateString();
    }

    ult_conex += ' a l(as) ';

    if (fecha.getHours() < 13 ) {
        ult_conex += fecha.getHours() + ':' + fecha.getMinutes() + ' a.m.';
    }
    else{
        ult_conex += (fecha.getHours()-12) + ':'+ fecha.getMinutes() + ' p.m.';}


    return ult_conex;
}