

(function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);

$(".messages").animate({ scrollTop: $(document).height() }, "fast");

    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function() {
        $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");

        if($("#status-online").hasClass("active")) {
        $("#profile-img").addClass("online");
    } else if ($("#status-away").hasClass("active")) {
        $("#profile-img").addClass("away");
    } else if ($("#status-busy").hasClass("active")) {
        $("#profile-img").addClass("busy");
    } else if ($("#status-offline").hasClass("active")) {
        $("#profile-img").addClass("offline");
    } else {
        $("#profile-img").removeClass();
    };

        $("#status-options").removeClass("active");
    });

    function newMessage() {
        message = $(".message-input input").val();
        if($.trim(message) == '') {
        return false;
    }
        $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
        $('.message-input input').val(null);
        $('.contact.active .preview').html('<span>You: </span>' + message);
        $(".messages").animate({ scrollTop: $(document).height() }, "fast");
    };

    $('.submit').click(function() {
        newMessage();
    });

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
        newMessage();
        return false;
    }
    });

function newMessage() {
    message = $(".message-input input").val();
    if($.trim(message) == '') {
        return false;
    }
    $('<li class="sent"><img src="/files/upload/profile/mikeross.png?w=40&h=40" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
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



//llamar elementos contactos
$("#seccion-contactos").click(function(){
    $(location).prop('href', '/contactos')
    /* $("#frame").empty();

     $.ajax({
         method: "GET",
         url: "/contactos"
     }).done(function(data) {
         $("#frame").append(data);
     });
 */
});
/*
/*llamar elementos chat*/
$("#seccion-conversaciones").click(function(){
    $(location).prop('href', '/')
    /* $("#frame").empty();

     $.ajax({
         method: "GET",
         url: "/temp"
     }).done(function(data) {
         $("#frame").html(data);
     });
 */
});
$("#ocultar").click(function (){

    $("#panelTodosContactos").animate({
        margin: "=0 auto 0 -600px"
    }, {
        duration: 500,
        queue: false
    });
    $("#frame #contenido").removeClass("desp-izq");
    if($( window ).width()> 735){
    if ($("body").hasClass("prev-inactivo")){
        $("body").removeClass("prev-inactivo");
    }
    else{
        $("body").toggleClass("sb-sidenav-toggled");

    }
   }
});

$("#nuevo-chat").click(function () {
    $("#panelTodosContactos").animate({
        margin: "=0 auto 0 0"
    }, {
        duration: 500,
        queue: false
    });
    if($( window ).width()> 735){
        $("#frame #contenido").addClass("desp-izq");
    if ($("body").hasClass("sb-sidenav-toggled")){
        $("body").addClass("prev-inactivo");
    }else{
        $("body").toggleClass("sb-sidenav-toggled");

    }
    }
    });


$("#btn-enviar-mensaje").click(function() {

    message = $(".message-input input").val();
    console.log(message);
    if($.trim(message) == '') {
        return false;
    }
    $('<li class="sent"><img src="/files/upload/profile/mikeross.png?w=40&h=40" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
    $('.message-input input').val(null);
    $('.contact.active .preview').html('<span>You: </span>' + message);
    $(".messages").animate({ scrollTop: $('.messages').prop("scrollHeight")}, 300);
});
$(".wrap input").bind("keyup keydown change",function () {
    console.log('activado')
    message = $(".wrap input").val();
    if ($.trim(message) == '') {
        $("#btn-enviar-mensaje").removeClass("activar")
    }
    else{
        $("#btn-enviar-mensaje").addClass("activar")
    }
});

    $("#btn-info-contacto").click(function (){
        $("#frame #contenido").addClass("desp-der");
        $("#frame #panelInfoContacto").addClass("mostrar");
        $("#btn-info-contacto").addClass("ocultar");
    });
$("#btn-cerrar-contacto").click(function (){
    $("#frame #contenido").removeClass("desp-der");
    $("#frame #panelInfoContacto").removeClass("mostrar");
    $("#btn-info-contacto").removeClass("ocultar");
});
    //detectar tamanos de pantalla y las acciones
    $(window).on('resize', function(){
        var win = $(this);
    if (win.width() < 765) { $("body").addClass("sb-sidenav-toggled")}
    });

/*
$(document).ready(function(){
    //al cargarse la pagina primero se muestran
    setTimeout(
        function (){
            $.ajax({
                method: "GET",
                url: "/temp"
            }).done(function(data) {
                $("#frame").append(data);
            })
                .fail(function() {
                    alert.lo("Algo salió mal")});}
        ,
        100);

});
//cuando se de click sobre cualquier contacto se llama a la conversacion que corresponde

$("li.contact").click(function(){
    $.ajax({
        method: "GET",
        url: "/conversacion"
    }).done(function(data) {
        $("#frame").appendChild(data);
    })
        .fail(function() {
            alert("Algo salió mal");});

});*/