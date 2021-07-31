$(document).ready(function () {
    if (!Notification) {
        alert("La version actual de tu navegador no soporta las notificaciones de escritorio");
        return;
    } else {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
            Notification.requestPermission(function (permission) {

                if (permission === "granted") {

                }
                else if(permission=="denied"){
                    VanillaToasts.create({
                        title:"SimpleChat",
                        text: "No se han permitido las notificaciones de escritorio para SimpleChat",
                        type: "error",
                        icon: "/files/icon/icono.png",
                        timeout: 10000,
                        close: true
                    });
                }
            });
        }
    }

});

//codigo temporal para emular las notificaciones de escritorio
$(document).on("click", "#icon-indicador-mensaje",  function () {
   // NotifiacionesEscritorio("SimpleChat", "SimpleChat te ha enviado una notificiación","/files/icon/icono.png");
    MensajeNuevo ("Harvey Specter","/files/profile/harveyspecter.png", "Hola");
});


function NotifiacionesEscritorio(titulo ,mensaje, imagen) {
    var opciones = {
        body: mensaje,
        icon: imagen
    }
    if (Notification.permission === "granted") {
        var notification = new Notification(titulo, opciones);
        VanillaToasts.create({
            title:"SimpleChat",
            text: "Texto de Notificacion",
            type: "info",
            icon: "/files/icon/icono.png",
            timeout: 10000,
            close: true
        });
    }

}

function MensajeNuevo(remitente, fotografia, previa){
    VanillaToasts.create({
        title:remitente,
        text: previa,
        type: "success",
        icon: fotografia,
        timeout: 1500,
        close: true
    });
}