function ObtenerMensajes(){
    const ajax = new XMLHttpRequest();
    ajax.open('GET', '/action/users/MIInstant', true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.onload = () => {
        switch (ajax.status){
            case 200:
                console.log('json');
                ObtenerMensajes();
                break;
            case 500:
                ObtenerMensajes();
                break;
        }
    }
    ajax.send();
}

setTimeout(ObtenerMensajes, 1000);