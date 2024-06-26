//desactivar boton atras
history.pushState(null, document.title, location.href);
window.addEventListener('popstate', function (e) {
    history.pushState(null, document.title, location.href);
    if (window.innerWidth < 576) {

        if ($("#panelTodosContactos").hasClass("mostrar")) {
            $("#ocultar").trigger("click");
        } else if (!($("body").hasClass("sb-sidenav-toggled"))) {
            $("#sidebarToggle").trigger("click");
        } else if ($("#panelInfoContacto").length && $("#panelInfoContacto").hasClass("mostrar")) {
            $("#btn-cerrar-contacto").trigger("click");
        } else if (!$("#espacio-de-chat").hasClass("no-visible-sm")) {
            $("#btn-chat-atras").trigger("click");
        } else if ($("#espacio-de-configuracion")) {
            $("#btn-cerrar-configuraciones").trigger("click");
        }
    }
});

$(window).on("load", function () {
    $("#frame").append($("#espacio-temporal"));
    $("#preloader").remove();
    $("#espacio-temporal .page-loader").remove();
    window.history.forward();
});

//
$(document).on("input", "#contenido-mensaje", function () {
    $("#frame .content .message-input .wrap .entrada-placeholder").hide();
})

const target = document.getElementById('contenido-mensaje');
target.addEventListener('paste', (e) => {
    $("#frame .content .message-input .wrap .entrada-placeholder").hide();
    let paste = (e.clipboardData || window.clipboardData).getData("text").replace(/(\r\n|\n|\r)/gm, "");

    const selection = window.getSelection();
    if (!selection.rangeCount) return false;
    selection.deleteFromDocument();
    selection.getRangeAt(0).insertNode(document.createTextNode(paste));
    e.preventDefault();
});

$(document).on("mouseover", ("#btn-habilitar-notificaciones"), function () {
    $(".msg-indicador-notificaciones").show();
});
$(document).on("mouseleave", ("#btn-habilitar-notificaciones"), function () {
    $(".msg-indicador-notificaciones").hide();
});

//Función que se ejecuta al hacer scroll en los mensajes
function CambiarUbicacion(e) {
    let h = $("#lista-mensajes").innerHeight() - $("#espacio-de-chat .messages").innerHeight() - 100;
    if ($("#espacio-de-chat .messages").scrollTop() < h) {
        $("#espacio-de-chat .hacia-abajo").addClass("visible");
    } else {
        $("#espacio-de-chat .hacia-abajo").removeClass("visible");
    }
}

$(document).on("click", "#espacio-de-chat .hacia-abajo", function () {
    $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
    $("#espacio-de-chat .hacia-abajo").removeClass("visible");
});


$("#LateralMenu").ready(function () {
    VistaMovil();

});

$(window).resize(function () {
    VistaMovil();
});

//Codigo para vista movil

function VistaMovil() {
    if (window.innerWidth > 576) {

        var usuario = $('#espacio-de-chat .messages').attr('data-nick');
        if (usuario) {
            $('#lista-conversaciones .contact .elemento-conversacion[data-usuario="' + usuario + '"]').parent().addClass("active");
        }
    }
}

$(document).on("click", "#lista-conversaciones .contact", function () {
    $("#sidepanel").addClass('no-visible-sm');
    $("body").addClass("sb-sidenav-toggled");
    $("#espacio-de-chat").removeClass('no-visible-sm');
    if (($("#sidebarToggle").hasClass("activo"))) {
        $("#sidebarToggle").removeClass("activo");
        $("#sidebarToggle").html('<span class="material-icons">menu</span>');
    }
});

$(document).on("click", "#btn-chat-atras", function () {
    Buffer_Conversaciones($("#espacio-de-chat .messages").attr("data-nick"), "");
    $("#sidepanel").removeClass('no-visible-sm');
    $("#espacio-de-chat").addClass('no-visible-sm');
    $("#lista-conversaciones li.active").removeClass("active");

})
$(".messages").on("swiperight", function () {
    alert("You swiped right!");
});

//Fin de código para vista movil


$(document).on("click", function (e) {

    var container = $("#btn-opciones-perfil");
    if ($("#list-opciones").length > 0) {
        if (!container.is(e.target) && container.has(e.target).length === 0 && container.length) {
            $("#list-opciones").remove();
        }
    }
    var opc_perfil = $("#mi-perfil-sidepanel");
    if ($("#mi-perfil-sidepanel .opciones-sesion").length) {
        if (!opc_perfil.is(e.target) && opc_perfil.has(e.target).length === 0 && opc_perfil.length) {

            $("#mi-perfil-sidepanel .usuario-perfil-opciones").removeClass("activo");
            $("#mi-perfil-sidepanel .opciones-sesion").remove();
        }
    }
    var opc_perfil_lat = $("#btn-sesion");
    if (opc_perfil_lat.children('.opciones-sesion').length) {
        if (!opc_perfil_lat.is(e.target) && opc_perfil_lat.has(e.target).length === 0 && opc_perfil_lat.length) {
            opc_perfil_lat.children(".usuario-perfil-opciones").removeClass("activo");
            opc_perfil_lat.children(".opciones-sesion").remove();
        }
    }
    var emojis = $('.wrapper');
    var btn_emojis = $('#btn-emojis');
    if (emojis.length) {

        if ((!emojis.is(e.target) && emojis.has(e.target).length === 0) && (!btn_emojis.is(e.target) && btn_emojis.has(e.target).length === 0)) {
            var button = $("#btn-emojis");
            button.removeClass("activo");
            button.text("sentiment_satisfied_alt");
        }
    }

    let espacio_chat = $('#espacio-de-chat');
    if (espacio_chat.length) {
        //Si el click se ha dado fuera del espacio de chat, finalizamos grabacion o reproduccion de audio en caso de que una de las dos se ejecute
        if ((!espacio_chat.is(e.target) && espacio_chat.has(e.target).length === 0)) {
            Finalizar_Grabacion_Reproduccion();
        }

    }
});


$("#sidebarToggle").on("click", function (e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");

    $(this).toggleClass("activo");
    if ($(this).hasClass("activo")) {
        $(this).html('<span class="material-icons">close</span>');
        $("#mi-perfil-sidepanel").addClass("no-visible");
    } else {
        $("#mi-perfil-sidepanel").removeClass("no-visible");
        $(this).html('<span class="material-icons">menu</span>');
    }
});


$("#profile-img").click(function () {
    $("#status-options").toggleClass("active");
});
$("#btn-sesion").click(function () {
    $("#btn-sesion").toggleClass("btn-activo");
    AgregarOpcionesSesion($("#btn-sesion"))
});

$('.submit').on('click', function () {
    newMessage();
});

//cerrar sesion
$(document).on("click", "#mi-perfil-sidepanel", function () {
    AgregarOpcionesSesion($("#mi-perfil-sidepanel"))
});

function AgregarOpcionesSesion(elemento) {
    elemento.children(".usuario-perfil-opciones").toggleClass("activo");

    if (elemento.children(".usuario-perfil-opciones").hasClass("activo")) {
        elemento.append(`
        <div class="opciones-sesion activo">
            <div class="item-opciones-sesion " id="btn-conf-sesion">
                <div title="Configuraciones de cuenta" class="opc-sesion">
                    <span class="material-icons">settings</span>
                    <p>Configuraciones</p>
                </div>
            </div>
            <div class="item-opciones-sesion ">
                <a href="/Logout" class="opc-sesion">
                    <span class="material-icons" title="Cerrar sesión">logout</span>
                    <p>Cerrar sesión</p>
                </a>
            </div>
        </div>`);
    } else {
        elemento.children(".opciones-sesion").remove();
    }

}

$(".expand-button").click(function () {
    $("#profile").toggleClass("expanded");
});


//activar uno de los elementos del menu lateral (seccion actual)
$('#LateralMenu li').on('click', function () {
    $('#LateralMenu li.active').removeClass('active');
    $(this).addClass('active');
});

function ConversacionActiva() {
    $('#LateralMenu li.active').removeClass('active');
    $('#LateralMenu li:first').addClass('active');
}

//Notificacion de solicitud de mensaje
$(document).on("mouseover click", "#mensaje-invitacion-si", function () {
    $("#icon-mensaje-invitacion").css("color", "#198754");
});
$(document).on("mouseleave", "#mensaje-invitacion-si", function () {
    $("#icon-mensaje-invitacion").css("color", "#00000070");
});
$(document).on("mouseover click", "#mensaje-invitacion-no", function () {
    $("#icon-mensaje-invitacion").css("color", "#dc3545");
});
$(document).on("mouseleave", "#mensaje-invitacion-no", function () {
    $("#icon-mensaje-invitacion").css("color", "#00000070");
});

/*
/*llamar elementos chat*/

$("#ocultar").on("click", function () {
    CerrarContactos();
    ConversacionActiva();
})
$(document).on("click", "li.item-contacto", function () {
    CerrarContactos();
    ConversacionActiva();
});

function CerrarContactos() {

    $("#panelTodosContactos").removeClass("mostrar");/*animate({
        margin: "=0 auto 0 -600px"
    }, {
        duration: 500,
        queue: false
    });*/
    if ($('body').width() > 1000) {
        if ($("body").hasClass("prev-inactivo")) {
            $("body").removeClass("prev-inactivo");
            $("body").removeClass("sb-sidenav-toggled");
        }
    }
    $("#cuadro-busqueda-usuario").val("");
    $('#lista-contactos').show();
    $('#lista-contactos-buscar').empty();
    $("#sin-resultados").html('<span>Mis contactos</span>');
    $("#buscar-contacto .borrar").remove();
    $("#layoutSidenav").removeClass("no-visible-sm");
};


function Contactos() {
    $("#panelTodosContactos").addClass("mostrar");
    /*({

    }, {
        duration: 500,
        queue: false
    });*/
    if ($(window).width() > 1000) {
        if (!$("body").hasClass("sb-sidenav-toggled")) {
            $("body").addClass("prev-inactivo");
        }
        $("body").addClass("sb-sidenav-toggled");
    }
    $("#frame #espacio-de-chat").addClass("expandido")
    $("#layoutSidenav").addClass("no-visible-sm")
};


//Panel de información de contactos.
$(document).on("click", "#btn-info-contacto", function () {
    $("#frame #espacio-de-chat").addClass("desp-der");
    $("#panelInfoContacto").addClass("mostrar");
    $("#btn-info-contacto").addClass("ocultar");
    $("#frame #espacio-de-chat").addClass("no-visible-sm");

});

$(document).on("click", "#btn-ver-todo", function () {
    const a = $(this);
    if(a.hasClass("activo")){
        $(this).removeClass("activo").html('<i class="fas fa-th-large"></i>Ver todo');
        $("#lista-img-conversacion").removeClass("vista-completa");
    }
    else{
        $(this).addClass("activo").html('<i class="fas fa-caret-square-up"></i>Colapsar');
        $("#lista-img-conversacion").addClass("vista-completa");
    }
});
function BuscarImagenesEnConversacion() {
    let imagenes = $("#lista-mensajes li .cont-msj img");
    if(imagenes.length < 1){
        $("#lista-img-conversacion").html(`<span>No hay archivos de imágen</span>`);
        $("#btn-ver-todo").addClass("inhabilitado");
    }
    else{
        $("#lista-img-conversacion").empty();
        if(imagenes.length < 4){
            $("#btn-ver-todo").addClass("inhabilitado");
        }
        else{
            $("#btn-ver-todo").removeClass("inhabilitado");
        }
        imagenes.each(function () {
            $("#lista-img-conversacion").prepend(`<div class="item-img-conv"><img class="" src="${$(this).attr("src")}" title="${$(this).attr("title")}" alt=""></div>`);
        })
        }
    const a = $("#btn-ver-todo");
    if(a.hasClass("activo")){
        $("#btn-ver-todo").removeClass("activo").html('<i class="fas fa-th-large"></i>Ver todo');
        $("#lista-img-conversacion").removeClass("vista-completa");
    }
}
function AgregarImagenAGaleria(url) {
    let imagenes = $("#lista-img-conversacion .item-img-conv img");
    if (imagenes.length == 0){
        $("#lista-img-conversacion").empty();
    }
    if(imagenes.length > 2 && $("#btn-ver-todo").hasClass("inhabilitado")){
        $("#btn-ver-todo").removeClass("inhabilitado");
    }
    $("#lista-img-conversacion").prepend(`<div class="item-img-conv"><img class="" src="/files/chat/${url}" title="${url}" alt=""></div>`);

}
$(document).on("click", ".item-img-conv img", function () {
    var imagen = $(this).attr("src");
    MostrarModal($(this).attr("title"), '<img src="' + imagen + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});
$(document).on("click", ".chat-conexion .nombre-chat", function () {
    $("#frame #espacio-de-chat").addClass("desp-der");
    $("#panelInfoContacto").addClass("mostrar");
    $("#frame #espacio-de-chat").addClass("no-visible-sm");
});
$(document).on("click", ".chat-conexion .ult-conex", function () {
    $("#frame #espacio-de-chat").addClass("desp-der");
    $("#panelInfoContacto").addClass("mostrar");
    $("#frame #espacio-de-chat").addClass("no-visible-sm");
});


$(document).on("click", "#btn-cerrar-contacto", function () {
    $("#frame #espacio-de-chat").removeClass("desp-der").removeClass("no-visible-sm");
    $("#panelInfoContacto").removeClass("mostrar");
    $("#btn-info-contacto").removeClass("ocultar");

});

$(document).on("click", ".contenedor-perfil .perfil .foto-perfil", function () {
    MostrarModal($(this).attr("title"), '<img src="' + ObtenerUrlImagen($(this)) + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});


//detectar tamanos de pantalla y las acciones


var picker;
$(document).on("click", "#btn-emojis", function () {

    var button = $("#btn-emojis");

    button.toggleClass("activo");
    var msj = document.getElementById('contenido-mensaje');
    if (button.hasClass("activo")) {
        button.text("keyboard_alt");

        picker = new EmojiButton({
            autoHide: false,
            showSearch: 0,
            autoFocusSearch: false,
        });
        picker.showPicker(button);

        picker.on('emoji', emoji => {

            $("#frame .content .message-input .wrap .entrada-placeholder").hide();
            $('#contenido-mensaje').text($("#contenido-mensaje").text() + emoji);
            $("#btn-enviar-mensaje").removeClass("modo-microfono").addClass("activar").html(`<i class="fas fa-paper-plane"></i>`).attr("title","Enviar mensaje");
            $("#cuadro-busqueda-usuario").after(' <div class="borrar"><span class="material-icons"> close</span></div>');

            //InsertarenContenedorMensaje(emoji);

        });
    } else {
        button.text("sentiment_satisfied_alt");
        if (picker.isPickerVisible)
            picker.hidePicker();
    }
});

//redireccion a otras paginas del sitio
$("#seccion-politicas").click(function () {
    $(location).attr("href", "/Privacy");
});
$("#seccion-acerca").click(function () {
    $(location).attr("href", "/About");
});
$("#seccion-contactanos").click(function () {
    $(location).attr("href", "/Contact");
});
//configuraciones de cuenta
$(document).on("click", "#btn-configuraciones", function () {
    if (!Buffer_Conversaciones($('#lista-conversaciones li.active .elemento-conversacion').attr("data-usuario"), ""))
        CargarEspacioConfiguraciones();
    $('ul#lista-conversaciones li.active').removeClass('active');


});
$(document).on("click", "#btn-conf-sesion", function () {
    $("#btn-cerrar-contacto").trigger("click");
    if (!Buffer_Conversaciones($('#lista-conversaciones li.active .elemento-conversacion').attr("data-usuario"), ""))
        CargarEspacioConfiguraciones();
    $("#mi-perfil-sidepanel .usuario-perfil-opciones").removeClass("activo");
    $("#mi-perfil-sidepanel .opciones-sesion").addClass("inactivo");
    $("#sidepanel").addClass("no-visible-sm");
    $("#espacio-de-configuracion").removeClass("no-visible-sm");
    if (($("#sidebarToggle").hasClass("activo"))) {
        $("#sidebarToggle").removeClass("activo");
        $("#sidebarToggle").html('<span class="material-icons">menu</span>');

    }
});
$(document).on("click", "#btn-cerrar-configuraciones", function () {
    $("#espacio-de-configuracion").addClass("no-visible-sm");
    $("#sidepanel").removeClass("no-visible-sm");
    $('#seccion-conversaciones').parent().addClass('active')
    ActualizarConversacion();
});

/*Busqueda en conversaciones*/
$(document).on("input", "#inputBuscarConversacion", function () {
    var texto = $(this).val().toLowerCase();
    $("#lista-conversaciones-buscar").empty();
    if (texto === "") {
        $("#lista-conversaciones").show();
        $("#lista-conversaciones-buscar").hide();
        $("#cerrar-busqueda-conversacion").removeClass("visible");
    } else {
        $("#lista-conversaciones").hide();
        $("#cerrar-busqueda-conversacion").addClass("visible");
        $("#lista-conversaciones li").each(function () {
            let li = $(this).clone();
            let nombre = li.find(".name");
            let indice = nombre.text().toLowerCase().search(texto);
            li.find(".preview i").remove();
            li.find(".preview span").remove();
            let preview = li.find(".preview");
            var indice_prev = preview.text().toLowerCase().search(texto);
            if (indice !== -1) {
                let contenido = nombre.text();
                nombre.html(contenido.substr(0, indice) + '<span class="resaltar">' + contenido.substr(indice, texto.length) + '</span>' + contenido.substr(indice + texto.length));
            }
            if (indice_prev !== -1) {
                let contenido = preview.text();
                preview.html('<p>' + contenido.substr(0, indice_prev) + '<span class="resaltar">' + contenido.substr(indice_prev, texto.length) + '</span>' + contenido.substr(indice_prev + texto.length) + '</p>');
            }
            if ((indice !== -1) || (indice_prev !== -1)) {
                $("#lista-conversaciones-buscar").show().append(li);
            }


        });
    }

});
$(document).on("click", "#lista-conversaciones-buscar li", function () {
    let elemento = $(this).children(".elemento-conversacion");
    $("#lista-conversaciones li.active").removeClass("active")
    $('#lista-conversaciones li .elemento-conversacion[data-usuario="' + elemento.attr("data-usuario") + '"]').parent().addClass("active");

});
$(document).on("click", "#cerrar-busqueda-conversacion", function () {
    $(this).removeClass("visible");
    $("#lista-conversaciones").show();
    $("#lista-conversaciones-buscar").empty().hide();
    $("#inputBuscarConversacion").val("");
});

/*Busqueda en conversaciones*/


function CargarEspacioConfiguraciones() {
    $("body").addClass("sb-sidenav-toggled");
    $("#mi-perfil-sidepanel").removeClass("no-visible");
    $("#btn-cerrar-contacto").trigger("click");
    $('#sh-setting').remove();
    $("#lista-conversaciones li").removeClass("active");
    $('#espacio-temporal').remove();
    $('#espacio-de-chat').hide();

    $('#espacio-de-configuracion').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).show().load(`/Settings`);
};

//enviar imagen
$(document).on("click", "#icon-archivo-imagen", function () {
    $("#archivo-imagen-enviar").trigger("click");
});
$(document).on("input", "#archivo-imagen-enviar", function () {
    const archivos = document.getElementById('archivo-imagen-enviar').files;
    if (!ValidarImagen(archivos)) {
        return;
    } else {
        AgregarBotonesEdicion("mensaje");
        if (archivos.length != 0) {
            let reader = new FileReader();
            reader.readAsDataURL(archivos[0]);
            const image = document.getElementById("img-tmp");
            reader.onload = function () {
                image.src = reader.result;
                LanzarEditor(image, NaN);
            };
            return;
        }

    }

});

function EnviarImagenEnChat(filename) {
    try {
        my_cropper.getCroppedCanvas({
            maxWidth: 2048,
            maxHeight: 2048,
            imageSmoothingQuality: "medium"
        }).toBlob(function (blob) {
            const formData = new FormData();
            formData.append('img', blob, filename);
            formData.append('contact', $('#espacio-de-chat > .messages').attr('data-usuario'))

            const progreso = $('<div class="barra-progreso"><div class="barra"></div></div>');
            let mensaje = ObtenerElementoImgEnviada(filename.split('\\').pop().split('/').pop(), URL.createObjectURL(blob));
            var remitente = $('#espacio-de-chat > .messages').attr('data-nick');
            $.ajax({
                url: '/action/users/chat/upload_img',
                type: 'post',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                retryLimit : 3,
                mimeType: 'application/json',

                xhr: function () {

                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var porcentaje = Math.trunc((evt.loaded / evt.total) * 100);
                            progreso.find('.barra').css("width", porcentaje + '%');
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: () => {
                    $("#lista-mensajes").append(mensaje);

                    $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
                    mensaje.find(".contenedor-imagen-enviada").prepend(progreso);
                },
                success: function (response) {
                    if (response[0]) {
                        mensaje.attr('data-id', response[2]);
                        mensaje.find('.extra-mensaje').html(ObtenerElementoExtraMensaje(ObtenerHora(new Date()), 1));
                        mensaje.find('img').attr("title", response[1]);
                        progreso.remove();

                        //Actualizar item de conversación.
                        AgregarElementoConversacion(remitente, '<span class="material-icons icon-indicador">image</span> Archivo de imagen');
                        //Actualizar Galería
                        AgregarImagenAGaleria(response[1]);

                    } else {
                        swal({
                            title: "¡Ha ocurrido un error!",
                            text: "No se ha podido subir la imagen. Por favor, asegúrese de seleccionar un archivo de imagen válido.",
                            icon: "error",
                            button: "Ok",
                        });
                    }
                },
                error: function () {
                    swal({
                        title: "¡Ha ocurrido un error!",
                        text: "No se ha subir la imagen. Por favor, verifique su conexión a Internet.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        });
    } catch (e) {
        console.log("Error al abrir el editor de imagen");
    } finally {
        CancelarEdicion();
    }
}

$(document).on("click", ".imagen-enviada", function () {
    var imagen = $(this).attr("src");
    MostrarModal($(this).attr("title"), '<img src="' + imagen + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});
$(document).on("click", ".imagen-recibida", function () {
    var imagen = $(this).attr("src");
    MostrarModal($(this).attr("title"), '<img src="' + imagen + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});


//botones para Edicion de fotos
function AgregarBotonesEdicion(elemento) {
    $('body').toggleClass('modoEdicionFotografia');
    if ($('body').hasClass('modoEdicionFotografia')) {
        $('body').prepend('<div id="botonera-edicion">\n' +
            '   <div class="edicion-desplazamiento"><button id="edicion-izquierda" title="Desplazar a la izquierda"><i class="fas fa-arrow-left"></i></button><button id="edicion-arriba" title="Desplazar a la derecha"><i class="fas fa-arrow-up"></i></button>' +
            '    <button id="edicion-abajo" title="Desplazar hacia abajo"><i class="fas fa-arrow-down"></i></button>\n' +
            '    <button id="edicion-derecha" title="Desplazar hacia arriba"><i class="fas fa-arrow-right"></i></button>\n' +
            '</div> \n' +

            '    <button id="edicion-girar-der" title=""><i class="fas fa-redo"></i></button>\n' +
            '    <button id="edicion-girar-izq" title=""><i class="fas fa-undo"></i></button>\n' +
            '    <button id="edicion-invertir-h" title=""><i class="fas fa-arrows-alt-h"></i></button>\n' +
            '    <button id="edicion-invertir-v" title=""><i class="fas fa-arrows-alt-v"></i></button>' +
            '<button id="edicion-encuadre" title=""><span class="material-icons">crop_free</span></button>' +
            '<div class="edicion-zoom"> <button id="edicion-zoom-mas" title=""><i class="fas fa-search-plus"></i></button>\n' +
            '    <button id="edicion-zoom-menos" title=""><i class="fas fa-search-minus"></i></button> </div>\n' +
            '    <div class="edicion-finalizar">\n' +
            '        <button id="edicion-enviar-' + elemento + '" title="Guardar cambios"><span class="material-icons">done</span></button> <button id="edicion-cerrar-' + elemento + '" title="Cancelar"><span class="material-icons">close</span></button>\n' +
            '        </div>\n' +
            '\n' +
            '</div><div id="contenedor-editor"> <img id="img-tmp"> </>');
    } else {
        $("#botonera-edicion").remove();
    }


}

$(document).on("click", "#edicion-cerrar-perfil", function () {

    CancelarEdicion();
    $("#nueva-foto-perfil").val("");
});

$(document).on("click", "#edicion-cerrar-mensaje", function () {
    CancelarEdicion();
    $("#archivo-imagen-enviar").val("");
});

$(document).on("click", "#edicion-enviar-mensaje", function () {
    const file_input = $("#archivo-imagen-enviar");
    EnviarImagenEnChat(file_input.val());
    $('body').removeClass('modoEdicionFotografia')
    $("#botonera-edicion").remove();
    $("#contenedor-editor").remove();
    file_input.val("");
});
$(document).on("click", "#edicion-enviar-perfil", function () {
    $('body').removeClass('modoEdicionFotografia')
    $("#botonera-edicion").remove();
    $("#contenedor-editor").remove();
    EnviarImagen();
});

$(document).on("click", "#edicion-arriba", function () {
    my_cropper.move(0, 10);
});
$(document).on("click", "#edicion-abajo", function () {
    my_cropper.move(0, -10);
});
$(document).on("click", "#edicion-izquierda", function () {
    my_cropper.move(10, 0);
});
$(document).on("click", "#edicion-derecha", function () {
    my_cropper.move(-10, 0);
});
$(document).on("click", "#edicion-girar-der", function () {
    my_cropper.rotate(90);
});
$(document).on("click", "#edicion-girar-izq", function () {
    my_cropper.rotate(-90);
});
$(document).on("click", "#edicion-invertir-h", function () {
    my_cropper.scaleX(-1);
    $(this).toggleClass('activo')
    if ($(this).hasClass('activo')) {
        my_cropper.scaleX(-1);
    } else {
        my_cropper.scaleX(1);
    }
});

$(document).on("click", "#edicion-invertir-v", function () {

    $(this).toggleClass('activo')
    if ($(this).hasClass('activo')) {
        my_cropper.scaleY(-1);
    } else {
        my_cropper.scaleY(1);
    }

});

$(document).on("click", "#edicion-zoom-mas", function () {
    my_cropper.zoom(0.1);
});
$(document).on("click", "#edicion-zoom-menos", function () {
    my_cropper.zoom(-0.1);
});
$(document).on("click", "#edicion-encuadre", function () {
    ancho = my_cropper.getImageData().naturalWidth;
    alto = my_cropper.getImageData().naturalHeight;
    my_cropper.setCropBoxData({width: ancho, height: alto,});
});

//Funciones
function ValidarImagen(archivos) {

    //El navegador debe soportar la lectura de archivos
    if (!window.FileReader) {
        swal({
            title: "¡Ha ocurrido un error!",
            text: "El navegador no soporta la lectura de archivos.",
            icon: "info",
        });
        return false;
    }

    //El archivo debe ser una imagen
    if (!(/\.(jpg|png|gif|jpeg)$/i).test(archivos[0].name)) {
        swal({
            title: "¡Ha ocurrido un error!",
            text: "El archivo seleccionado no es un archivo de imágen. Por favor, seleccione un archivo de imágen válido.",
            icon: "warning",
        });
        return false;
    }

    //El tamano del archivo no debe ser mayor a 15 MB
    if ((archivos[0].size / 1048576) > 15) {
        swal({
            title: "¡Ha ocurrido un error!",
            text: "El peso de la imágen no debe superar los 15 MB. Por favor, seleccione una imágen válida.",
            icon: "warning",
        });
        return false;
    }
    return true;
}

function CancelarEdicion() {
    $('body').removeClass('modoEdicionFotografia')
    $("#botonera-edicion").remove();
    $("#contenedor-editor").remove();
    my_cropper.clear();
    my_cropper.reset();
    delete my_cropper;
}

$("#espacio-de-chat").blur(function () {
    let usuario = $("#espacio-de-chat").find(".messages").attr("data-nick");
    Buffer_Conversaciones(usuario, "");
});

//al cerrar la ventana tambien se cierra sesion
window.onbeforeunload = function () {

}
//Eventos para audios
let audio = null, aux = null, aux_2 = null, audio_aux = null;
$(document).on("click", ".boton-play-pause", function () {
    const objeto_actual = $(this);
    const elemento_audio = objeto_actual.siblings(".mensaje-audio")
    let audio_actual = new Audio(elemento_audio.attr('src'));
    if (audio) {
        if (audio_actual.src !== audio.src) {
            aux_2 = aux;
            audio_aux = audio;
            DetenerAudio(audio_aux);
        }
    }
    if (!$(this).hasClass("reproduciendo") && !$(this).hasClass("pausado")) {
        objeto_actual.parent().removeClass("no-escuchado");
        const barra_progreso = objeto_actual.parent().find(".control-indicador-total");
        const etiqueta_tiempo = objeto_actual.parent().find(".control-tiempo-total");
        audio = null;
        audio = audio_actual;
        const duracion_audio = elemento_audio.attr("data-duration");
        let cronometro = null;
        let t_transcurrido = 0;

        audio.onplay = (e) => {
            cronometro = setInterval(function () {
                t_transcurrido += 50;
                let porcentaje = Math.trunc((t_transcurrido / duracion_audio) * 100);
                barra_progreso.css("width", porcentaje + '%');
                etiqueta_tiempo.text(ObtenerSegundosComoTiempo(t_transcurrido / 1000));
            }, 50);
            objeto_actual.addClass("reproduciendo").removeClass("pausado").html('<i class="far fa-pause-circle"></i>');
            aux = objeto_actual;
        };

        audio.onended = (e) => {
            //Se finaliza el cronómetro y se reinician los valores del indicador de tiempo y del icono
            clearInterval(cronometro);
            barra_progreso.css("width", '1%')
            objeto_actual.html('<i class="far fa-play-circle"></i>').removeClass("reproduciendo").removeClass("pausado");
            objeto_actual.siblings(".control-tiempo-total").text(ObtenerSegundosComoTiempo(objeto_actual.siblings(".mensaje-audio").attr('data-duration') / 1000));
            audio = null;
        };

        audio.onpause = (e) => {
            clearInterval(cronometro);
            objeto_actual.html('<i class="far fa-play-circle"></i>').removeClass("reproduciendo").addClass("pausado");
            Reiniciar(aux_2);
        }

        audio.play();
    } else if (objeto_actual.hasClass("reproduciendo")) {
        if (!audio) {
            return;
        }
        audio.pause();
    } else if (objeto_actual.hasClass("pausado")) {
        if (!audio) {
            return;
        }
        audio.play();
    }
});

function DetenerAudio(pista) {
    if (pista.paused) {
        //Se reinician los contadores e icono de reproducción del elemento audio anterior (si estaba en estado pause)
        aux_2.html('<i class="far fa-play-circle"></i>').removeClass("reproduciendo").removeClass("pausado").parent().find(".control-indicador-total").css("width", '1%')
        aux_2.siblings(".control-tiempo-total").text(ObtenerSegundosComoTiempo(aux_2.siblings(".mensaje-audio").attr('data-duration') / 1000));
    } else {
        pista.pause();
    }
    pista.currentTime = 0;
    pista = null;
}

function Reiniciar(elemento) {
//Se reinician los contadores e icono de reproducción del elemento audio anterior
    if (elemento) {
        elemento.html('<i class="far fa-play-circle"></i>').removeClass("reproduciendo").removeClass("pausado").parent().find(".control-indicador-total").css("width", '1%')
        elemento.siblings(".control-tiempo-total").text(ObtenerSegundosComoTiempo(aux_2.siblings(".mensaje-audio").attr('data-duration') / 1000));
        elemento = null;
    }
}

//Cancelar grabacion
$(document).on("click", "#panel-grabando .cancelar-grabacion", function () {
    $("#panel-grabando").remove();
    if (!grabacion) return;
    grabacion.stop();
    DetenerContador();
});
$(document).on("click", "#panel-grabando .fin-grabacion", function () {
    $("#panel-grabando").remove();
    if (!grabacion) return;
    grabacion.onstop = function () {
        DetenerContador();
        let mensaje = ObtenerElementoMensajeAudioEnviado(URL.createObjectURL(track), tiempoFin);
        mensaje.find(".control-tiempo-total").text(ObtenerSegundosComoTiempo(tiempoFin / 1000));
        grabacion = null;
        EnviarGrabacion(mensaje);
    }
    grabacion.stop();
});



let idIntervalo, tiempoInicio, tiempoFin = 0;

const Contador = () => {
    tiempoInicio = Date.now();
    idIntervalo = setInterval(ActualizarReloj, 500);
};
const DetenerContador = () => {
    clearInterval(idIntervalo);
    tiempoFin = parseInt(Date.now() - tiempoInicio);
    grabacion = null;
    tiempoInicio = null;
}
const ActualizarReloj = () => {
    $("#panel-grabando").find(".tiempo-transcurrido").text(ObtenerSegundosComoTiempo((Date.now() - tiempoInicio) / 1000));
}


function AgregarControlesGrabando() {
    if ($("#panel-grabando").length === 0) {
        $("#espacio-de-escritura").append(`<div id="panel-grabando">
                            <div class="indicador-tiempo">
                                <div class="led-recording"></div>
                                <div class="tiempo-transcurrido">00:00</div>

                            </div>
                                <div class="cancelar-grabacion" title="Cancelar">
                                    <i class="fas fa-trash"></i>
                                </div>
                                <div class="fin-grabacion" title="Enviar audio">
                                    <div class="cont-icon-fin-grabacion"><i class="fas fa-paper-plane"></i></div>
                                </div>
                            </div>`);
    }

}

function Finalizar_Grabacion_Reproduccion() {
    if (grabacion) {
        if (grabacion.state === 'recording') {
            grabacion.stop();
        }
    }
    if (audio) {
        aux_2 = aux;
        DetenerAudio(audio);
    }
    $("#panel-grabando").remove();
}