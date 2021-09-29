//desactivar boton atras
$("#icon-indicador-mensaje").on("click", function (){
  /**/  VanillaToasts.create({
        title: "Hola",
        text: "este es un ejemplo de mensaje largo asi que no te preocupes por meter texto demsaiado largo en tus alertas, este es un ejemplo de mensaje largo asi que no te preocupes por meter texto demsaiado largo en tus alertas, este es un ejemplo de mensaje largo asi que no te preocupes por meter texto demsaiado largo en tus alertas, este es un ejemplo de mensaje largo asi que no te preocupes por meter texto demsaiado largo en tus alertas, este es un ejemplo de mensaje largo asi que no te preocupes por meter texto demsaiado largo en tus alertas",
        type: "success",
        icon: "/files/icon/icono.png",
        timeout: 30000,
        close: true
    });
});

history.pushState(null, document.title, location.href);
window.addEventListener('popstate', function (event)
{
    history.pushState(null, document.title, location.href);
    console.log("Hacia atras");
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


$(document).on("click", (".indicador-mensajes"), function () {

});
$(document).on("mouseover", ("#btn-habilitar-notificaciones"), function () {
$(".msg-indicador-notificaciones").show();
});
$(document).on("mouseleave", ("#btn-habilitar-notificaciones"), function () {
    $(".msg-indicador-notificaciones").hide();
});


$("#LateralMenu").ready(function () {
    VistaMovil();

});

$(window).resize(function () {
    VistaMovil();
});
//Codigo para vista movil

function VistaMovil(){
   if(window.innerWidth > 576 ){
       /* $('#LateralMenu li.active').removeClass('active');
        if($("#espacio-de-chat .messages").length){
            var usuario = $('#espacio-de-chat .messages').attr('data-nick')
            $('#lista-conversaciones .contact .elemento-conversacion[data-usurio="'+usuario+'"]').addClass("active");
            console.log(usuario);
        }
*/
    } /*
    else{
        $('#seccion-conversaciones').parent().addClass('active')
    }*/
}
/*
$("#seccion-conversaciones").on("click", function () {

    if(window.innerWidth < 576){
        $("#sidebarToggle").trigger('click');
        $("#sidepanel").removeClass('no-visible-sm');
        $("#espacio-temporal").remove();
    }
});
*/
$(document).on("click","#lista-conversaciones .contact", function (){
    $("#sidepanel").addClass('no-visible-sm');
    $("body").addClass("sb-sidenav-toggled");
    $("#espacio-de-chat").removeClass('no-visible-sm');
    if(($("#sidebarToggle").hasClass("activo"))){
        $("#sidebarToggle").removeClass("activo");
        $("#sidebarToggle").html('<span class="material-icons">menu</span>');
    }
});

$(document).on("click","#btn-chat-atras", function () {
    $("#sidepanel").removeClass('no-visible-sm');
    $("#espacio-de-chat").addClass('no-visible-sm');
    $("#lista-conversaciones li.active").removeClass("active");
})
$(".messages").on("swiperight",function(){
    alert("You swiped right!");
});
//Fin de codigo para vista movil



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
    if(opc_perfil_lat.children('.opciones-sesion').length){
        if (!opc_perfil_lat.is(e.target) && opc_perfil_lat.has(e.target).length === 0 && opc_perfil_lat.length){
            opc_perfil_lat.children(".usuario-perfil-opciones").removeClass("activo");
            opc_perfil_lat.children(".opciones-sesion").remove();
        }
    }
    var emojis =$('.wrapper');
    var btn_emojis= $('#btn-emojis');
    if(emojis.length){

        if ((!emojis.is(e.target) && emojis.has(e.target).length === 0) && (!btn_emojis.is(e.target) && btn_emojis.has(e.target).length === 0) ) {
            var button = $("#btn-emojis");
            button.removeClass("activo");
            button.text("sentiment_satisfied_alt");
        }
    }
});


$("#sidebarToggle").on("click", function (e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
    $("#mi-perfil-sidepanel").toggleClass("no-visible");
    $(this).toggleClass("activo");
    if( $(this).hasClass("activo")){
        $(this).html('<span class="material-icons">close</span>');
    }
    else{
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
$(document).on("click", "#mi-perfil-sidepanel",  function () {
    AgregarOpcionesSesion($("#mi-perfil-sidepanel"))
});
function AgregarOpcionesSesion(elemento){
elemento.children(".usuario-perfil-opciones").toggleClass("activo");

    if(elemento.children(".usuario-perfil-opciones").hasClass("activo")){
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
    }else{
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
$(document).on("mouseover click", "#mensaje-invitacion-si",function () {
    $("#icon-mensaje-invitacion").css("color","#198754");
});
$(document).on("mouseleave", "#mensaje-invitacion-si",function () {
    $("#icon-mensaje-invitacion").css("color","#00000070");
});
$(document).on("mouseover click", "#mensaje-invitacion-no",function () {
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

$(document).on("click", ".chat-conexion", function () {
    $("#frame #espacio-de-chat").addClass("desp-der");
    $("#panelInfoContacto").addClass("mostrar");
    $("#frame #espacio-de-chat").addClass("no-visible-sm");
});

$(document).on("click", "#btn-cerrar-contacto", function () {
    $("#frame #espacio-de-chat").removeClass("desp-der");
    $("#frame #espacio-de-chat").removeClass("no-visible-sm");
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
var picker;
$(document).on("click", "#btn-emojis", function () {

    var button = $("#btn-emojis");

    button.toggleClass("activo");
    var msj = document.getElementById('contenido-mensaje');

        /*if(obj_sele= document.getSelection().focusNode.parentNode){
          if( obj_sele!== msj){
                obj = window.getSelection();
                obj.removeAllRanges();
               // msj.focus();
            }}*/
    if(button.hasClass("activo")){
        button.text("keyboard_alt");

        picker= new EmojiButton({
            autoHide: false,
            showSearch: 0,
            autoFocusSearch: false,
        });
        picker.showPicker(button);

        picker.on('emoji', emoji => {

            $("#frame .content .message-input .wrap .entrada-placeholder").hide();

            $('#contenido-mensaje').text($("#contenido-mensaje").text()+emoji);
            //InsertarenContenedorMensaje(emoji);

        });
    }else{
        button.text("sentiment_satisfied_alt");
        if(picker.isPickerVisible)
        picker.hidePicker();
    }

});

function InsertarenContenedorMensaje(emoji){
    var msj = $("#contenido-mensaje");
    var obj = document.getElementById('contenido-mensaje');
    obj_sele= document.getSelection();
    if( obj_sele.rangeCount < 1){
        $("#contenido-mensaje").append(emoji);
        return;
    }
    let inicio =obj_sele.getRangeAt(0).startOffset;
   let  fin =obj_sele.getRangeAt(0).endOffset;
   console.log(obj_sele.rangeCount+ "   >> "+ inicio);

let cadena = "";
    cadena=  $("#contenido-mensaje").text().toString();
    $("#contenido-mensaje").text("");
    var range = document.createRange();
    console.log(cadena);
if (inicio === 0){
    if (cadena.length == 0){
        $("#contenido-mensaje").text(emoji)
    }
    else if(inicio==0) {
        $("#contenido-mensaje").text(emoji + cadena);
    }
    /*range.setStart(obj_sele.focusNode.childNodes[0], (inicio) + 1);
    var sel = window.getSelection();*/
}else{
    console.log("Longitud de cadena: " +cadena.length);
    if(cadena.length == fin){
        $("#contenido-mensaje").text(cadena.substr(0,(inicio)+1)+ emoji);
    }else{
        $("#contenido-mensaje").text(cadena.substr(0,inicio)+ emoji);
    }

}/*
*/
/*
   if(!(cadena))
       cadena = emoji;
   else
       cadena = cadena.substr(0, (inicio)+1) + `${emoji}` +cadena.substr((fin)+1);

  //  $("#contenido-mensaje").text(cadena);
    var el = document.getElementById("contenido-mensaje");
    var range = document.createRange();

    var sel = window.getSelection();
if(!el.childNodes[0]){
    range.setStart(obj_sele.anchorNode, inicio);
    range.insertNode(document.createTextNode(emoji));
    console.log("no tiene:"+obj_sele.anchorNode);
    range.collapse(true);
    var range = document.createRange();
    let pos_fin = fin + 1;
    range.setStart(obj_sele.anchorNode, pos_fin);
}
else {
    range.setStart(obj_sele.focusNode, inicio);
    range.insertNode(document.createTextNode(emoji));
    let pos_fin = fin + 1;
    range.setStart(obj_sele.focusNode, pos_fin);
   // range.setStart(obj_sele.focusNode, pos_fin)
    /*range.setStart(obj_sele.focusNode.parentNode, inicio);
    range.insertNode(document.createTextNode(emoji));
   // console.log("Si tiene:"+obj_sele.focusNode.parentNode);

}*/



//console.log( obj_sele.anchorNode+"   > "+pos_fin);

    /*
       range.setStart(el.childNodes[0], (inicio)+1);

   /*
       console.log(el.childNodes[0]);
       range.setStart(el, inicio);

    sel.removeAllRanges();
  sel.addRange(range);*/
return;
}
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
    $('ul#lista-conversaciones li.active').removeClass('active');
    CargarEspacioConfiguraciones();

});
$(document).on("click", "#btn-conf-sesion", function () {
    $("#mi-perfil-sidepanel .usuario-perfil-opciones").removeClass("activo");
    $("#mi-perfil-sidepanel .opciones-sesion").addClass("inactivo");
    $("#sidepanel").addClass("no-visible-sm");
    $("#espacio-de-configuracion").removeClass("no-visible-sm");
    if(($("#sidebarToggle").hasClass("activo"))){
        $("#sidebarToggle").removeClass("activo");
        $("#sidebarToggle").html('<span class="material-icons">menu</span>');
    }
    CargarEspacioConfiguraciones();

});
$(document).on("click", "#btn-cerrar-configuraciones", function () {
    $("#espacio-de-configuracion").addClass("no-visible-sm");
    $("#sidepanel").removeClass("no-visible-sm");
    $('#seccion-conversaciones').parent().addClass('active')

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
    if(!ValidarImagen( archivos)){
        return;
    }else {
        AgregarBotonesEdicion("mensaje");
        if (archivos.length != 0) {

            let reader = new FileReader();
            reader.readAsDataURL(archivos[0]);
            const image = document.getElementById("img-tmp");
            reader.onload = function () {
                image.src = reader.result;
                LanzarEditor(image, NaN);
            };
            $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight"));
            return;
        }

    }

});
 function EnviarImagenEnChat() {
     console.log( my_cropper.getCroppedCanvas({maxWidth: 2048, maxHeight: 2048,imageSmoothingQuality:"medium"}));
  my_cropper.getCroppedCanvas({maxWidth: 2048, maxHeight: 2048,imageSmoothingQuality:"medium"}).toBlob(function (blob) {
      console.log(blob);
      var tiempo = new Date();

       var nombre = 'img_' + tiempo.getDate() + tiempo.getMonth() + tiempo.getFullYear() + '_' + tiempo.getHours() + tiempo.getMinutes() + tiempo.getSeconds();

          var img = $('<li class="enviado"><div class="dir"></div><div class="cont-msj contenedor-imagen-enviada"><img class="imagen-enviada" id="' + nombre + '" title="' + nombre + '" tittle="' + nombre + '"></div></li>');
          $("#lista-mensajes").append(img);
          var progreso = $('<div class="barra-progreso"><div class="barra"></div></div>');

          var img = $('#' + nombre + '');
         img.before(progreso);
         BarradeCargaTemporal(progreso);
       img.attr("src", URL.createObjectURL(blob));
     });
 }

function BarradeCargaTemporal(progreso) {

    var id = setInterval(frame, 10);
    var width = 1;
    function frame() {
        if (width >= 100) {
            clearInterval(id);
            i = 0;
        } else {
            width++;
            progreso.find(".barra").css("width",width+'%');
        }
    }
}


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
function AgregarBotonesEdicion(elemento) {
    $('body').toggleClass('modoEdicionFotografia');
    if($('body').hasClass('modoEdicionFotografia')){
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
            '        <button id="edicion-enviar-'+elemento+'" title="Guardar cambios"><span class="material-icons">done</span></button> <button id="edicion-cerrar-'+elemento+'" title="Cancelar"><span class="material-icons">close</span></button>\n' +
            '        </div>\n' +
            '\n' +
            '</div><div id="contenedor-editor"> <img id="img-tmp"> </>');
    }else{
        $("#botonera-edicion").remove();
    }


}

$(document).on("click", "#edicion-cerrar-perfil", function (){

    CancelarEdicion();
    $("#nueva-foto-perfil").val("");
    /*img_result.cropper('clear');
    img_result.cropper('destroy');
    img_result.attr('src','');*/
});

$(document).on("click", "#edicion-cerrar-mensaje", function (){
    CancelarEdicion();
$("#archivo-imagen-enviar").val("");
});

$(document).on("click", "#edicion-enviar-mensaje", function (){
    EnviarImagenEnChat();
    $('body').removeClass('modoEdicionFotografia')
    $("#botonera-edicion").remove();
    $("#contenedor-editor").remove();
    $("#archivo-imagen-enviar").val("");

});
$(document).on("click", "#edicion-enviar-perfil", function (){
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
$(document).on("click", "#edicion-encuadre", function (){
ancho= my_cropper.getImageData().naturalWidth;
alto= my_cropper.getImageData().naturalHeight;
    my_cropper.setCropBoxData({width: ancho, height: alto,});
});

//Funciones
 function ValidarImagen( archivos) {

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
 function CancelarEdicion(){
     $('body').removeClass('modoEdicionFotografia')
     $("#botonera-edicion").remove();
     $("#contenedor-editor").remove();
     my_cropper.clear();
     my_cropper.reset();
     delete my_cropper;
 }

//eventos mobile
/*
$(document).on("mousedown",function(e){
    var a= e.pageX;
    console.log("voy hacia la izquierda "+ a);
});
$(document).on("mouseup",function(e){
    var a= e.pageX;
    console.log("voy hacia la izquierda "+ a);
});

 */