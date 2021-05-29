

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
    $(location).prop('href', '/chat')
    /* $("#frame").empty();

     $.ajax({
         method: "GET",
         url: "/temp"
     }).done(function(data) {
         $("#frame").html(data);
     });
 */
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