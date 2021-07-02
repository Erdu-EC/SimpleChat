$(document).on("load", function () {
    $("#espacio-de-chat .messages").hide();

});



$(document).ready(function (){
    if($(window).width()<735){
        $("body").addClass("sb-sidenav-toggled");
    }


});
$("#sidebarToggle").on("click", function(e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
});

$(".messages").animate({
    scrollTop: $(document).height() }, "fast");

$("#profile-img").click(function() {
    $("#status-options").toggleClass("active");
});
$(window).resize(function (){
    if($(window).width()<935){
        $("body").addClass("sb-sidenav-toggled");
    }
    else{
        $("body").removeClass("sb-sidenav-toggled");
    }
});

$("#btn-sesion").click(function (){
    $("#btn-sesion").toggleClass("btn-activo");
});

$('.submit').on('click',function() {
    newMessage();
});



function newMessage() {
    message = $(".message-input input").val();
    if($.trim(message) == '') {
        return false;
    }
    $('<li class="enviado"><img src="/files/profile/mikeross.png?w=40&h=40" alt="" /><p>' + message + '</p></li>').appendTo($('#'));

$('.message-input input').val(null);
    $('.contact.active .preview').html('<span>You: </span>' + message);
    $(".messages").animate({ scrollTop: $('.messages').prop("scrollHeight")}, 300);

};

$(".expand-button").click(function() {
    $("#profile").toggleClass("expanded");
    //  $("#contacts").toggleClass("expanded");
});


//activar uno de los elementos del menu lateral (seccion actual)
$('#LateralMenu li').on('click', function(){
    $('li.active').removeClass('active');
    $(this).addClass('active');
});



/*
/*llamar elementos chat*/

$("#ocultar").click(function () {
    CerrarContactos();
})
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


function Contactos () {
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

$("#btn-info-contacto").on("click",function (){
    $("#frame #espacio-de-chat").addClass("desp-der");
    $("#panelInfoContacto").addClass("mostrar");
    $("#btn-info-contacto").addClass("ocultar");
    if($('#frame .content').width() < 400){
        $('body').addClass(sb-sidenav-toggled);
    }
});
$("#btn-cerrar-contacto").on("click",function (){
    $("#frame #espacio-de-chat").removeClass("desp-der");
    $("#panelInfoContacto").removeClass("mostrar");
    $("#btn-info-contacto").removeClass("ocultar");
    if($('#frame .content').width()< 400){
        $('body').removeClass(sb-sidenav-toggled);
    }
});
//detectar tamanos de pantalla y las acciones

$("div#contacts ul#lista-conversaciones").on("click","li.contact",function () {

    $('div#contacts ul#lista-conversaciones li.active').removeClass('active');
    $(this).addClass("active");

});
