/*$(document).ready(function () {
    $("#espacio-de-chat .messages").hide();
    $('#espacio-de-configuracion').hide();
});*/

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

});


$("#sidebarToggle").on("click", function (e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
    $("#mi-perfil-sidepanel").toggleClass("no-visible");
    $(this).toggleClass("activo");
});


$("#profile-img").click(function () {
    $("#status-options").toggleClass("active");
});
$("#btn-sesion").click(function () {
    $("#btn-sesion").toggleClass("btn-activo");
});

$('.submit').on('click', function () {
    newMessage();
});

//cerrar sesion
$(document).on("click", "#mi-perfil-sidepanel", function () {
    $("#mi-perfil-sidepanel .usuario-perfil-opciones").toggleClass("activo");

    if($("#mi-perfil-sidepanel .usuario-perfil-opciones").hasClass("activo")){
        $("#mi-perfil-sidepanel").append(`
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
    }else{
        $("#mi-perfil-sidepanel .opciones-sesion").remove();
    }

});

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
$(document).on("mouseover", "#mensaje-invitacion-si",function () {
    $("#icon-mensaje-invitacion").css("color","#198754");
});
$(document).on("mouseleave", "#mensaje-invitacion-si",function () {
    $("#icon-mensaje-invitacion").css("color","#00000070");
});
$(document).on("mouseover", "#mensaje-invitacion-no",function () {
    $("#icon-mensaje-invitacion").css("color","#dc3545");
});
$(document).on("mouseleave", "#mensaje-invitacion-no",function () {
    $("#icon-mensaje-invitacion").css("color","#00000070");
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

    $("#panelTodosContactos").animate({
        margin: "=0 auto 0 -600px"
    }, {
        duration: 500,
        queue: false
    });
    if ($('body').width() > 1000) {
        if ($("body").hasClass("prev-inactivo")) {
            $("body").removeClass("prev-inactivo");
            $("body").removeClass("sb-sidenav-toggled");
        }
    }
    $("#cuadro-busqueda-usuario").val("");
    $('#lista-contactos').show();
    $("#sin-resultados").empty();
    $("#buscar-contacto .borrar").remove();
};


function Contactos() {
    $("#panelTodosContactos").animate({
        margin: "=0 auto 0 0"
    }, {
        duration: 500,
        queue: false
    });
    if ($(window).width() > 1000) {
        if (!$("body").hasClass("sb-sidenav-toggled")) {
            $("body").addClass("prev-inactivo");
        }
        $("body").addClass("sb-sidenav-toggled");
    }
    $("#frame #espacio-de-chat").addClass("expandido")
};


$("#espacio-de-escritura .wrap input").on("keyup keydown change", function () {

    message = $(".wrap input").val();
    if ($.trim(message) == '') {
        $("#btn-enviar-mensaje").removeClass("activar")
    } else {
        $("#btn-enviar-mensaje").addClass("activar")
    }
});

//Panel de información de contactos.
$(document).on("click", "#btn-info-contacto", function () {
    $("#frame #espacio-de-chat").addClass("desp-der");
    $("#panelInfoContacto").addClass("mostrar");
    $("#btn-info-contacto").addClass("ocultar");

});

$(document).on("click", "#btn-cerrar-contacto", function () {
    $("#frame #espacio-de-chat").removeClass("desp-der");
    $("#panelInfoContacto").removeClass("mostrar");
    $("#btn-info-contacto").removeClass("ocultar");

});

$(document).on("click", ".contenedor-perfil .perfil .foto-perfil", function () {
    MostrarModal("Mike Ross", '<img src="' + ObtenerUrlImagen($(this)) + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});

//detectar tamanos de pantalla y las acciones
/*
$("div#contacts ul#lista-conversaciones").on("click", "li.contact", function () {

    $('div#contacts ul#lista-conversaciones li.active').removeClass('active');
    $(this).addClass("active");

});*/

$(document).on("click", "#btn-emojis", function () {
    var button = $("#btn-emojis");
    var msj = $("#contenido-mensaje");
    var picker = new EmojiButton();
    picker.on('emoji', emoji => {
        msj.val(msj.val() + emoji);
    });

    picker.togglePicker(button);
});
//redireccion a otras paginas del sitio
$("#seccion-politicas").click(function () {
    $(location).attr("href", "/Privacy");
});
$("#seccion-acerca").click(function () {
    $(location).attr("href", "About");
});

//configuraciones de cuenta
$(document).on("click", "#btn-configuraciones", function () {
    $('ul#lista-conversaciones li.active').removeClass('active');
    CargarEspacioConfiguraciones();

});
$(document).on("click", "#btn-conf-sesion", function () {
    $("#mi-perfil-sidepanel .usuario-perfil-opciones").removeClass("activo");
    $("#mi-perfil-sidepanel .opciones-sesion").addClass("inactivo");
    CargarEspacioConfiguraciones();

});

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
    var tiempo = new Date();

    var nombre = 'img_' + tiempo.getDate() + tiempo.getMonth() + tiempo.getFullYear() + '_' + tiempo.getHours() + tiempo.getMinutes() + tiempo.getSeconds();
    var img = $('<li class="enviado"><div class="dir"></div><div class="cont-msj contenedor-imagen-enviada"><img class="imagen-enviada" id="' + nombre + '" title="' + nombre + '" tittle="' + nombre + '"></div></li>');
    $("#lista-mensajes").append(img);
    var img = $('#' + nombre + '');
    if (archivos.length != 0) {

        let reader = new FileReader();
        reader.readAsDataURL(archivos[0]);

        reader.onload = function () {
            img.attr("src", reader.result);

        };
        $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
        return;
    }
});
$(document).on("load", ".imagen-enviada", function () {
    $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
});
$(document).on("click", ".imagen-enviada", function () {
    var imagen = $(this).attr("src");
    MostrarModal($(this).attr("tittle"), '<img src="' + imagen + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});
$(document).on("click", ".imagen-recibida", function () {
    var imagen = $(this).attr("src");
    MostrarModal($(this).attr("tittle"), '<img src="' + imagen + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});


//botones para Edicion de fotos
function AgregarBotonesEdicion() {
    $('body').toggleClass('modoEdicionFotografia');
    if($('body').hasClass('modoEdicionFotografia')){
        $('body').prepend('<div id="botonera-edicion">\n' +
            '    <button id="edicion-izquierda" title="Desplazar a la izquierda"><i class="fas fa-arrow-left"></i></button>\n' +
            '    <button id="edicion-arriba" title="Desplazar a la derecha"><i class="fas fa-arrow-up"></i></button>\n' +
            '    <button id="edicion-abajo" title="Desplazar hacia abajo"><i class="fas fa-arrow-down"></i></button>\n' +
            '    <button id="edicion-derecha" title="Desplazar hacia arriba"><i class="fas fa-arrow-right"></i></button>\n' +
            '    <button id="edicion-girar-der" title=""><i class="fas fa-redo"></i></button>\n' +
            '    <button id="edicion-girar-izq" title=""><i class="fas fa-undo"></i></button>\n' +
            '    <button id="edicion-invertir-h" title=""><i class="fas fa-arrows-alt-h"></i></button>\n' +
            '    <button id="edicion-invertir-v" title=""><i class="fas fa-arrows-alt-v"></i></button>\n' +
            '\n' +
            '    <button id="edicion-zoom-mas" title=""><i class="fas fa-search-plus"></i></button>\n' +
            '    <button id="edicion-zoom-menos" title=""><i class="fas fa-search-minus"></i></button>\n' +
            '    <div class="edicion-finalizar">\n' +
            '        <button id="edicion-enviar" title="Guardar cambios"><span class="material-icons">done</span></button> <button id="edicion-cerrar" title="Cancelar"><span class="material-icons">close</span></button>\n' +
            '        </div>\n' +
            '\n' +
            '</div><div id="contenedor-editor"> <img id="img-tmp"> </>');
    }else{
        $("#botonera-edicion").remove();
    }


}

$(document).on("click", "#edicion-cerrar", function (){
    $('body').removeClass('modoEdicionFotografia')
    $("#botonera-edicion").remove();
    $("#contenedor-editor").remove();
    my_cropper.reset();
    /*img_result.cropper('clear');
    img_result.cropper('destroy');
    img_result.attr('src','');*/
});
$(document).on("click", "#edicion-enviar", function (){
    $('body').removeClass('modoEdicionFotografia')
    $("#botonera-edicion").remove();
    $("#contenedor-editor").remove();
    EnviarImagen();
});

$(document).on("click", "#edicion-arriba", function (){
    my_cropper.move(0,10);
});
$(document).on("click", "#edicion-abajo", function (){
    my_cropper.move(0,-10);
});
$(document).on("click","#edicion-izquierda" , function (){
    my_cropper.move(10,0);
});
$(document).on("click","#edicion-derecha" , function (){
    my_cropper.move(-10,0);
});
$(document).on("click", "#edicion-girar-der", function (){
    my_cropper.rotate(90);
});
$(document).on("click", "#edicion-girar-izq", function (){
    my_cropper.rotate(-90);
});
$(document).on("click", "#edicion-invertir-h",function (){
    my_cropper.scaleX(-1);
   $(this).toggleClass('activo')
    if($(this).hasClass('activo')){
        my_cropper.scaleX(-1);
    }
    else{
        my_cropper.scaleX(1);
    }
});

$(document).on("click", "#edicion-invertir-v",function (){

   $(this).toggleClass('activo')
    if($(this).hasClass('activo')){
        my_cropper.scaleY(-1);
    }
    else{
        my_cropper.scaleY(1);
    }

});

$(document).on("click","#edicion-zoom-mas", function (){
    my_cropper.zoom(0.1);
});
$(document).on("click","#edicion-zoom-menos",function (){
    my_cropper.zoom(-0.1);
});