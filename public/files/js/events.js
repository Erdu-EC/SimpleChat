$(document).on("load", function () {
    $("#espacio-de-chat .messages").hide();

});

$("#sidebarToggle").on("click", function(e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
    $("#mi-perfil-sidepanel").toggleClass("no-visible");
    $(this).toggleClass("activo");
});


$("#profile-img").click(function() {
    $("#status-options").toggleClass("active");
});
$("#btn-sesion").click(function (){
    $("#btn-sesion").toggleClass("btn-activo");
});

$('.submit').on('click',function() {
    newMessage();
});

//cerrar sesion
$(document).on("click", "#mi-perfil-sidepanel", function (){
    $("#mi-perfil-sidepanel .usuario-perfil-opciones").toggleClass("activo");
    $("#mi-perfil-sidepanel .opciones-sesion").toggleClass("inactivo");
});

$(".expand-button").click(function() {
    $("#profile").toggleClass("expanded");
});


//activar uno de los elementos del menu lateral (seccion actual)
$('#LateralMenu li').on('click', function(){
    $('#LateralMenu li.active').removeClass('active');
    $(this).addClass('active');
});

function ConversacionActiva (){
    $('#LateralMenu li.active').removeClass('active');
    $('#LateralMenu li:first').addClass('active');
}


/*
/*llamar elementos chat*/

$("#ocultar").on("click",function () {
    CerrarContactos();
    ConversacionActiva();
})
$(document).on("click","li.item-contacto" ,function () {
    CerrarContactos();
    ConversacionActiva();
});

function CerrarContactos(){

    $("#panelTodosContactos").animate({
        margin: "=0 auto 0 -600px"
    }, {
        duration: 500,
        queue: false
    });
    if($('body').width() > 1000) {
        if ($("body").hasClass("prev-inactivo")) {
            $("body").removeClass("prev-inactivo");
            $("body").removeClass("sb-sidenav-toggled");
        }
    }
};


function Contactos() {
    $("#panelTodosContactos").animate({
        margin: "=0 auto 0 0"
    }, {
        duration: 500,
        queue: false
    });
    if($(window).width() > 1000){
        if (!$("body").hasClass("sb-sidenav-toggled")){
            $("body").addClass("prev-inactivo");
        }
        $("body").addClass("sb-sidenav-toggled");
    }
        $("#frame #espacio-de-chat").addClass("expandido")
};


$("#espacio-de-escritura .wrap input").on("keyup keydown change",function () {
    console.log('activado')
    message = $(".wrap input").val();
    if ($.trim(message) == '') {
        $("#btn-enviar-mensaje").removeClass("activar")
    }
    else{
        $("#btn-enviar-mensaje").addClass("activar")
    }
});

//Panel de información de contactos.
$(document).on("click","#btn-info-contacto",function (){
    $("#frame #espacio-de-chat").addClass("desp-der");
    $("#panelInfoContacto").addClass("mostrar");
    $("#btn-info-contacto").addClass("ocultar");

});

$(document).on("click","#btn-cerrar-contacto",function (){
    $("#frame #espacio-de-chat").removeClass("desp-der");
    $("#panelInfoContacto").removeClass("mostrar");
    $("#btn-info-contacto").removeClass("ocultar");

});

//detectar tamanos de pantalla y las acciones
$("div#contacts ul#lista-conversaciones").on("click","li.contact",function () {

    $('div#contacts ul#lista-conversaciones li.active').removeClass('active');
    $(this).addClass("active");

});

$(document).on("click", "#btn-emojis", function () {
    var button = $("#btn-emojis");
    var msj = $("#contenido-mensaje");
    var picker = new EmojiButton();
    picker.on('emoji', emoji => {
        msj.val (msj.val() + emoji);
    });

    picker.togglePicker(button);
});
//redireccion a otras paginas del sitio
$("#seccion-politicas").click(function () {
 $(location).attr("href","/Privacy");
});
$("#seccion-acerca").click(function () {
 $(location).attr("href","About");
});

//configuraciones de cuenta
$(document).on("click", "#btn-configuraciones", function () {
    $('ul#lista-conversaciones li.active').removeClass('active');
    CargarEspacioConfiguraciones();

});
$(document).on("click", "#btn-conf-sesion", function () {
    CargarEspacioConfiguraciones();

});

function CargarEspacioConfiguraciones(){
    $("body").addClass("sb-sidenav-toggled");
    $("#mi-perfil-sidepanel").removeClass("no-visible");
    $('#espacio-de-chat').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).load(`/Settings`);

};