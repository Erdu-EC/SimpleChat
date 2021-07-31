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
    NotifiacionesEscritorio("SimpleChat", "SimpleChat te ha enviado una notificiación", "/files/icon/icono.png");
    MensajeNuevo("Harvey Specter", "/files/profile/harveyspecter.png", "Hola");
});


function NotificacionesEscritorio(origen, titulo, mensaje, imagen) {
    var opciones = {
        body: mensaje,
        icon: imagen ?? "/files/icon/icono.png",
        tag: origen,
        renotify: true
    }
    if (Notification.permission === "granted") {
        new Notification(titulo, opciones);
    } else {
        VanillaToasts.create({
            title: "SimpleChat",
            text: "Texto de Notificacion",
            type: "info",
            icon: "/files/icon/icono.png",
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