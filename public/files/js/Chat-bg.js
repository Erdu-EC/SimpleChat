function ObtenerMensajes() {
    // noinspection InfiniteLoopJS
    while (true){
        const ajax = new XMLHttpRequest();
        ajax.open('GET', '/action/users/MIInstant', false);
        ajax.setRequestHeader("Content-type", "application/json");
        ajax.send();

        switch (ajax.status) {
            case 200:
                self.postMessage(JSON.parse(ajax.response));
                break;
            /*case 500:
                console.log('Sin respuesta.')
                break;*/
        }
    }
}

setTimeout(ObtenerMensajes, 1000);