function ObtenerMensajes() {
    // noinspection InfiniteLoopJS
    while (true){
        const ajax = new XMLHttpRequest();
        ajax.open('GET', '/action/users/MIInstant', false);
        ajax.setRequestHeader("Content-type", "application/json");
        ajax.onload = () => {
            switch (ajax.status) {
                case 200:
                    console.log('Datos obtenidos');
                    break;
                case 500:
                    console.log('Sin respuesta.')
                    break;
            }
        }
        ajax.send();
    }
}

setTimeout(ObtenerMensajes, 1000);