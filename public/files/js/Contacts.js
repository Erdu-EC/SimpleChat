//Panel de información de contacto.
$(document).on('click', '#btn-info-contacto', ActualizarInfoContacto);

$(document).on('click', '#btn-cerrar-contacto', function (){

});

function ActualizarInfoContacto(){
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
                perfil.find('img').attr('src', null).attr('src', new URL($('.contact-profile img').attr('src'), window.location.origin).pathname + "?w=100");
                perfil.find('h5').text(json[0] + " " + json[1]);
                perfil.find('h6').text("@" + json[2]);
                perfil.find('small').text(json[3] ?? '');

                const extra = contenedor.find('.card.contacto-extra');
                extra.find('.tel span').text(' - ');
                extra.find('.email span').text(json[4] ?? ' - ');
                extra.find('.fn span').text(json[5] ?? ' - ');

                let sexo = '';
                switch (json[6]){
                    case 'M':
                        sexo = 'Masculino';
                        break;
                    case 'F':
                        sexo = 'Femenino';
                        break;
                    case null:
                        sexo = 'No especificado';
                        break;
                    default:
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
});

///////
$(document).on('input', '#cuadro-busqueda-usuario', function () {
    const lista_resultados = $('#lista-contactos-buscar').html('');
    const lista_contactos = $('#lista-contactos');
    const entrada = $(this).val().trim();

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
                // console.log("Buscando..."),//alerta.text("Buscando..."),
            },
            error: () => {
                //console.log( "No fue posible realizar la busqueda."),//alerta.text("No fue posible realizar la busqueda."),
            }, success: function (json) {
                if (json === null) {
                    //console.log("Se recibieron nulos");
                    // alerta.text('No fue posible realizar la busqueda.');
                } else if (json.length === 0) {
                    //alerta.text('No hay coincidencias.');
                    //console.log("Se recibieron nulos");
                } else {
                    lista_resultados.html('');

                    json.forEach((registro) => {
                        $('<li>', {
                            class: 'item-contacto',
                            html: ObtenerElementoContactoBuscado(registro[0], registro[1], registro[2], registro[3], registro[4]),
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
                    $('<li>', {
                        class: 'item-contacto',
                        html: ObtenerElementoContacto(registro[0], registro[1], registro[2], registro[3], registro[4]),
                    }).appendTo(lista_contactos);
                });
            }
        }
    });
}

const ObtenerElementoContactoBuscado = (usuario, nombres, apellidos, foto_perfil, esContacto) =>
    `
<div class="elemento-contacto " data-usuario="${usuario}">

                            <div class="img-perfil-contacto">
                                <img src="${foto_perfil}?w=60&h=60" alt="" class="online"/>
                            </div>
                                <div class="cuerpo-perfil-contacto">
                                    <span class="nombre-contacto">${nombres} ${apellidos}</span>

                                    <div class="nombre-usuario">
                                        <span class="material-icons icon-usuario">person</span>
${usuario}
                                        </div>
                                        
                                        <!--<small class="text-muted">
                            ${(esContacto) ? '<i class="material-icons" style="vertical-align: middle">person</i><span>Mi contacto</span>' : ''}
                        </small>-->
                                </div>
                    </div>
`;

const ObtenerElementoContacto = (usuario, nombres, apellidos, ultima_conexion, foto_perfil) =>
    `
<div class="elemento-contacto" data-usuario="${usuario}">

                            <div class="img-perfil-contacto">
                                <img src="${foto_perfil}?w=60&h=60" alt="" class="online"/>
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


function ObtenerTiempoUltimaConexion(fecha_hora) {
    const fecha = new Date(fecha_hora);
    var fecha_actual = new Date();
    var ult_conex = 'últ. conex.';

    if (fecha_hora == null) {
        return ult_conex = 'Inactivo';
    }

    if (fecha.getDate() == fecha_actual.getDate()) {
        ult_conex += ' hoy'
    } else if (fecha_actual.getDate() - fecha.getDate() == 1) {
        ult_conex += ' ayer'
    } else {
        ult_conex += ' ' + fecha.toLocaleDateString();
    }

    ult_conex += ' a l(as) ';

    if (fecha.getHours() < 13) {
        ult_conex += fecha.getHours() + ':' + fecha.getMinutes() + ' a.m.';
    } else {
        ult_conex += (fecha.getHours() - 12) + ':' + fecha.getMinutes() + ' p.m.';
    }


    return ult_conex;
}