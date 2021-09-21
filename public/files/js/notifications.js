$(document).ready(function () {
    if (!Notification) {
        VanillaToasts.create({
            title: "SimpleChat",
            text: "La version actual de tu navegador no soporta las notificaciones de escritorio",
            type: "error",
            icon: "/files/icon/icono.png",
            timeout: 10000,
            close: true
        });
        return;
    }
    if (!(Notification.permission === "granted")) {
        $("#icon-indicador-mensaje").after('<div class="indicador-notifiaciones" id="btn-habilitar-notificaciones"><i class="fas fa-bell-slash"></i> </div>');
        $(".msg-indicador-notificaciones").show();
        setTimeout(function () {
            $(".msg-indicador-notificaciones").hide();
        }, 4000);
    } else {
        $(".msg-indicador-notificaciones").remove();
    }
});
$(document).on("click", "#btn-habilitar-notificaciones", function () {
    Notification.requestPermission().then(function (
        permission) {
        if (permission === "denied") {
            VanillaToasts.create({
                title: "SimpleChat",
                text: "No se han permitido las notificaciones de escritorio para SimpleChat",
                type: "error",
                icon: "/files/icon/icono.png",
                timeout: 10000,
                close: true
            });
        } else {
            $("#btn-habilitar-notificaciones").remove();
            $(".msg-indicador-notificaciones").remove();
        }
    });
});


function NotificacionesEscritorio(origen, titulo, mensaje, imagen) {

    if (!document.hasFocus()) {
        var opciones = {
            body: mensaje,
            icon: imagen === null ? "/files/icon/icono.png" : imagen + "?w=50&h=50",
            tag: origen,
            renotify: true,
            silent: true,
        }
        if (Notification.permission === "granted") {
            var n = new Notification(titulo, opciones);
            n.onclick = function (event) {
                window.focus();
            }
            n.onshow = function (event) {
                AudioNotificacion();
            }
        }
    }
}

function MensajeNuevo(origen, titulo, mensaje, imagen) {

if(document.hasFocus()) {
        VanillaToasts.create({
            title: titulo,
            text: mensaje,
            type: "info",
            icon: imagen === null ? "/files/icon/icono.png" : imagen + "?w=50&h=50",
            timeout: 2000,
            close: true
        });
    AudioNotificacion();
    }
else{
    NotificacionesEscritorio(origen, titulo, mensaje, imagen);
}

}

function AudioNotificacion(){

    var music = new Audio('/files/song/notification.mp3');
    var err = music.play().catch (function (e){
        console.log("No se ha podido reproducir el sonido de notificación");
    });
}