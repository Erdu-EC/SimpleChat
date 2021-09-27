self.addEventListener('notificationclick', function (event) {
    //Cerrando notificación.
    event.notification.close();

    //Mostrando ventana del navegador.
    event.waitUntil(clients.matchAll({
        type: "window"
    }).then(function (clientList) {
        clientList[0].focus();

        /*if (clients.openWindow)
            clients.openWindow('/');*/
    }));
});