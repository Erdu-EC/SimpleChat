//Panel de información de contacto.
$(document).on('click', '#btn-info-contacto', ActualizarInfoContacto);

$(document).on('click', '#btn-cerrar-contacto', function () {

});

function ActualizarInfoContacto() {
    const contenedor = $('#panelInfoContacto .contenedor-perfil');
    const usuario = $('#espacio-de-chat .messages').attr('data-usuario');

    //Si ya se tiene la información de este usuario, no volverla a solicitar.
    if (contenedor.attr('data-ult-contacto') === usuario)
        return;

    //Solicitando información.
    $.ajax('/action/contacts/info', {
        method: 'post', dataType: 'json', mimeType: 'application/json',
        data: {
            c: usuario
        },
        beforeSend: () => {
            contenedor.hide().after(ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary'));
        },
        error: () => {
            //console.log( "No fue posible realizar la busqueda."),//alerta.text("No fue posible realizar la busqueda."),
        }, success: function (json) {
            if (json === null || json.length === 0) {
                // alerta.text('No fue posible obtener la información.');
            } else {
                //Guardando información del ultimo contacto obtenido.
                contenedor.attr('data-ult-contacto', usuario);

                //Rellenando datos.
                const perfil = contenedor.find('.card.perfil');
                perfil.find('img').attr('src', null).attr('src', ObtenerUrlImagen($('.contact-profile img')) );
                perfil.find('img').attr('data-fuente', ObtenerUrlImagen($('.contact-profile img')));
                perfil.find('h5').text(json[0] + " " + json[1]);
                perfil.find('h6').html('<i class="fas fa-user"></i>'+ json[2]);
                perfil.find('small').text(ObtenerInformacionEstado(json[3],json[4]));

                const extra = contenedor.find('.card.contacto-extra');
                extra.find('.tel span').text(json[8] ?? ' - ');
                extra.find('.email span').text(json[5] ?? ' - ');
                extra.find('.fn span').text(ObtenerFecha(json[6]));

                let sexo = '';
                switch (json[7]) {
                    case 'M':
                        sexo = 'Masculino';
                        break;
                    case 'F':
                        sexo = 'Femenino';
                        break;
                    case 'D':
                        sexo = 'No especificado';
                        break;
                    case 'O':
                        sexo = 'Otro';
                        break;
                }

                extra.find('.sexo span').text(sexo)
                contenedor.show();
            }

            //Quitando contenedor de animación de carga.
            $('#panelInfoContacto > div:last-child').remove();
        }
    });
}

$("#seccion-contactos").on("click", function () {
    $("#sidepanelTodosContactos .titulo-cab h1").html("Contactos");
    Contactos();
    actualizar_lista_contactos();
});

$("#nuevo-chat").on("click", function () {
    $("#sidepanelTodosContactos .titulo-cab h1").html("Nuevo Chat");
    Contactos();
    actualizar_lista_contactos();
});

//agregar boton de borrar texto en cuadro de busqueda de contactos
$(document).on("keyup change", "#cuadro-busqueda-usuario", function () {
    const cuadro_busqueda = $("#cuadro-busqueda-usuario");

    if ($.trim(cuadro_busqueda.val()) === '') {
        $("#buscar-contacto .borrar").remove();
        $('#lista-contactos').show();
    } else {
        if (!$("#buscar-contacto .borrar").length)
            cuadro_busqueda.after(' <div class="borrar"><span class="material-icons">close</span></div>');
    }
});

$(document).on("click", '#buscar-contacto .borrar', function () {
    $("#cuadro-busqueda-usuario").val("");
    $('#lista-contactos-buscar').empty();
    $('#lista-contactos').show();
    $("#buscar-contacto .borrar").remove();
    $("#listaTodosContactos #sin-resultados").empty();
});

///////
$(document).on('input', '#cuadro-busqueda-usuario', function () {
    const lista_resultados = $('#lista-contactos-buscar').html('');
    const lista_contactos = $('#lista-contactos');
    const entrada = $(this).val().trim();
 var msg_error= $("#listaTodosContactos #sin-resultados");//si existe mensajes anteriores lo eliminamos
    msg_error.empty();
    if (entrada === '') {
        lista_contactos.show();
        return;
    } else
        lista_contactos.hide();

    if (entrada.length > 3) {

        $.ajax('/action/users/search', {
            method: 'post', dataType: 'json', mimeType: 'application/json',
            data: {
                text: entrada
            },
            beforeSend: () => {
                msg_error.html('<div id="sin-resultados"><span >Buscando...</span></div>');

            },
            error: () => {
                msg_error.html('<div id="sin-resultados"><span >No fue posible realizar la búsqueda. Revise su conexión a Internet</span></div>');

                 },
            success: function (json) {
                if (json === null) {
                    msg_error.html('<span >No fue posible realizar la búsqueda.</span>');
                } else if (json.length === 0) {
                    msg_error.html('<span >No se han encontrado coincidencias.</span>');
                } else {
                    msg_error.empty();
                    lista_resultados.html('');

                    json.forEach((registro) => {
                        var estado=Clase_Segun_Estado(registro[4]);

                        $('<li>', {
                            class: 'item-contacto',
                            html: ObtenerElementoContactoBuscado(registro[0], registro[1], registro[2], registro[3], registro[5], estado),
                        }).appendTo(lista_resultados);
                    });
                }
            }
        });
    }
});

$(document).on('click', '.elemento-contacto', CargarEspacioDeChat);


function actualizar_lista_contactos() {
    const lista_contactos = $('#lista-contactos').html('');

    $.ajax('/action/users/contacts', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        beforeSend: () => lista_contactos.html(ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')),
        error: () => {
            //alerta.text('No fue posible cargar la lista de contactos.')
        },
        success: function (json) {
            if (json === null) {
                //alerta.text('No fue posible cargar la lista de contactos.');
            } else if (json.length === 0) {
                lista_contactos.html('');
                //alerta.html('Tu lista de contactos esta vacia.<br/><br/>¡Busca nuevos contactos y agregalos!');
            } else {
                lista_contactos.html('')

                json.forEach((registro) => {
                    var estado=Clase_Segun_Estado(registro[3]);
                    $('<li>', {
                        class: 'item-contacto',
                        html: ObtenerElementoContacto(registro[0], registro[1], registro[2], registro[4], registro[5], estado),
                    }).appendTo(lista_contactos);
                });
            }
        }
    });
}

const ObtenerElementoContactoBuscado = (usuario, nombres, apellidos, foto_perfil, esContacto, estado) =>
    `
<div class="elemento-contacto " data-usuario="${usuario}">

                            <div class="img-perfil-contacto">
                                <img src="${foto_perfil}?w=60&h=60" alt="" class="${estado}"/>
                            </div>
                                <div class="cuerpo-perfil-contacto">
                                    <span class="nombre-contacto">${nombres} ${apellidos}</span>

                                    <div class="nombre-usuario">
                                         ${(esContacto) ? '<span class="material-icons icon-usuario">person</span>': '<span class="material-icons icon-usuario">person</span>'}
                                                            ${usuario}
                                    </div>
                                </div>
                    </div>
`;

const ObtenerElementoContacto = (usuario, nombres, apellidos, ultima_conexion, foto_perfil, estado) =>
    `
<div class="elemento-contacto" data-usuario="${usuario}">

                            <div class="img-perfil-contacto">
                                <img src="${foto_perfil}?w=60&h=60" alt="" class="${estado}"/>
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
function ObtenerInformacionEstado(estado, ultimaConexion){
    var info_estado="";
    switch (estado){
        case 'A':
            info_estado = 'En linea'
            break;
        case 'I':
            info_estado= ObtenerTiempoUltimaConexion(ultimaConexion);
            break;
        case 'O':
            info_estado = "Ocupado";
            break;
    }

    return info_estado;
}

function ObtenerTiempoUltimaConexion(fecha_hora) {
    const fecha = new Date(fecha_hora);
    var fecha_actual = new Date();
    var ult_conex = 'últ. conex.';

    if (fecha_hora == null) {
        return ult_conex = 'Inactivo';
    }

    if (fecha_actual.getDate() - fecha.getDate() == 0) {
        ult_conex += ' hoy'
    } else if (fecha_actual.getDate() - fecha.getDate() == 1) {
        ult_conex += ' ayer'
    } else {
        ult_conex += ' ' + fecha.toLocaleDateString();
    }

    ult_conex += ' a l(as) ';

    if (fecha.getHours() < 13) {
        ult_conex += fecha.getHours() + ':';
        ult_conex += (fecha.getMinutes() < 10 ? '0' : '') + fecha.getMinutes();
        ult_conex += ' a.m.';
    } else {
        ult_conex += (fecha.getHours() - 12) + ':';
        ult_conex += (fecha.getMinutes() < 10 ? '0' : '') + fecha.getMinutes();
        ult_conex += ' p.m.';
    }
    return ult_conex;

}
function Clase_Segun_Estado(est){
    var estado='';
    switch(est){
        case 'I':
            estado='inactivo';
            break;
        case 'A':
            estado= 'online'
            break;
        case 'O':
            estado ='ocupado';
            break;
    }
    console.log(est);
    return estado;
}
