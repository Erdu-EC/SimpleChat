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
    } else if (Notification.permission !== "granted") {
        Notification.requestPermission().then(function (permission) {
            if (permission === "denied") {
                VanillaToasts.create({
                    title: "SimpleChat",
                    text: "No se han permitido las notificaciones de escritorio para SimpleChat",
                    type: "error",
                    icon: "/files/icon/icono.png",
                    timeout: 10000,
                    close: true
                });
            }
        });
    }
});

//codigo temporal para emular las notificaciones de escritorio
$(document).on("click", "#icon-indicador-mensaje", function () {
    NotificacionesEscritorio("SimpleChat", "SimpleChat te ha enviado una notificiación", "/files/icon/icono.png");
    MensajeNuevo("Harvey Specter", "/files/profile/harveyspecter.png", "Hola");
});


function NotificacionesEscritorio(origen, titulo, mensaje, imagen) {
    var opciones = {
        body: mensaje,
        icon: imagen === null ? "/files/icon/icono.png" : imagen + "?w=50&h=50",
        tag: origen,
        renotify: true
    }
    if (Notification.permission === "granted") {
        new Notification(titulo, opciones);
    } else {
        VanillaToasts.create({
            title: titulo,
            text: mensaje,
            type: "info",
            icon: imagen === null ? "/files/icon/icono.png" : imagen + "?w=50&h=50",
            timeout: 10000,
            close: true
        });
    }
}

function MensajeNuevo(remitente, fotografia, previa) {
    VanillaToasts.create({
        title: remitente,
        text: previa,
        type: "success",
        icon: fotografia,
        timeout: 1500,
        close: true
    });
}