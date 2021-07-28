$(document).ready(function () {
    if (!Notification) {
        alert("La version actual de tu navegador no soporta las notificaciones de escritorio");
        return;
    } else {
        if (Notification.permission !== "grant") {
            Notification.requestPermission();
        }
    }

});