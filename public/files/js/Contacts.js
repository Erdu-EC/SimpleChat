$(document).ready(actualizar_lista_contactos);

$(document).on('input', '#cuadro-busqueda-usuario', function () {
    const alerta = $('#alerta-busqueda-usuario').html('');
    const lista_resultados = $('#lista-resultados-busqueda').html('');

    if ($(this).val().length > 3) {
        $.ajax('/action/users/search', {
            method: 'post', dataType: 'json', mimeType: 'application/json',
            data: {text: $(this).val()},
            beforeSend: () => alerta.text("Buscando..."),
            error: () => alerta.text("No fue posible realizar la busqueda."),
            success: function (json) {
                if (json === null)
                    alerta.text('No fue posible realizar la busqueda.');
                else if (json.length === 0)
                    alerta.text('No hay coincidencias.');
                else {
                    alerta.text(`Se ha encontrado ${json.length} coincidencias.`);

                    json.forEach((registro) => {
                        $('<li>', {
                            class: 'list-group-item border-0 ps-0 pe-0',
                            html: ObtenerElementoContactoBuscado(registro[0], registro[1], registro[2], registro[3]),
                        }).appendTo(lista_resultados);
                    });
                }
            }
        });
    }
});

$(document).on('click', '.elemento-contacto', function () {
    $('#espacio-de-chat').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).load(`/Chats/${$(this).attr('data-usuario')}`);
});

$(document).on('click', '.btn-agregar-contacto', function () {

});

function actualizar_lista_contactos() {
    const alerta = $('#alerta-lista-contactos').html('');
    const lista_contactos = $('#lista-contactos').html('');

    $.ajax('/action/users/contacts', {
        method: 'get', dataType: 'json', mimeType: 'application/json',
        error: () => alerta.text('No fue posible cargar la lista de contactos.'),
        success: function (json) {
            if (json === null)
                alerta.text('No fue posible cargar la lista de contactos.');
            else if (json.length === 0)
                alerta.html('Tu lista de contactos esta vacia.<br/><br/>¡Busca nuevos contactos y agregalos!');
            else {
                alerta.html('Tienes ' + json.length + ' contacto(s)<br/><br/><small class="text-secondary">¡Busca nuevos contactos y agregalos!</small>')

                json.forEach((registro) => {
                    $('<li>', {
                        class: 'list-group-item ps-0 pe-0',
                        html: ObtenerElementoContacto(registro[0], registro[1], registro[2], registro[3]),
                    }).appendTo(lista_contactos);
                });
            }
        }
    });
}

const ObtenerElementoContactoBuscado = (usuario, nombres, apellidos, esContacto) =>
    `<div class="card mb-0 shadow elemento-contacto" style="cursor: pointer;" data-usuario="${usuario}">
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
    </div>`

const ObtenerElementoContacto = (usuario, nombres, apellidos, ultima_conexion) =>
    `<div class="card mb-2 elemento-contacto" data-usuario="${usuario}">
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
    </div>`;

function ObtenerTiempoUltimaConexion(fecha_hora) {
    const fecha = new Date(fecha_hora);
    return 'Activo el ' + fecha.toLocaleDateString() + " a las " + fecha.toLocaleTimeString();
}