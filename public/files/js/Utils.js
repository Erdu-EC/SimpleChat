function Icon_Circle_Load(width = '1rem', height = '1rem', width_view = 52, height_view = 52, style = '') {
      return ' <div class="page-loader"><span class="preloader-interior"></span></div>';
}

function ObtenerContenedorHtmlDeAnimacionDeCarga(width, height, clase = '') {
    return `<div class="container text-center d-flex flex-column flex-grow-1 h-100 justify-content-center ${clase}">
                <div class="row flex-grow-1">
                    <div class="col-12 align-self-end">
                        ${Icon_Circle_Load(width, height)}
                    </div>
                </div>
                <div class="row flex-grow-1">
                    <div class="col-12">
                        <h5 class="fw-bolder">Cargando</h5>
                    </div>
                </div>
            </div>
    `
}

function MostrarModal(titulo, contenido, evento_cierre, clases, color_boton="") {
    const elemento = $('<div>', {
        class: 'modal ' ,
        tabIndex: '-1',
        html: `
            <div class="modal-dialog ${clases}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${titulo}</h5>
                        <button type="button" class="btn-close ${color_boton}" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>${contenido}</p>
                    </div>
                </div>
            </div>`
    }).bind('hidden.bs.modal', evento_cierre);

    //Instanciando modal.
    new bootstrap.Modal(elemento[0], {
        keyboard: false
    }).show();
}

//Obtener Url de imagen.
const ObtenerUrlImagen = (elemento_img, width, height) => {
    const src = elemento_img.attr('src');
    let param = '';

    if (width !== undefined && height !== undefined)
        param = `?w=${width}&h=${height}`;
    else if (width !== undefined)
        param = `?w=${width}`;
    else if (height !== undefined)
        param = `?h=${height}`;
    
    return src.startsWith('data:image/') ? src : (new URL( src, window.location.origin).pathname) + param;
}

//Hora y Fecha.
function ObtenerHora(hora) {
    var act = new Date(hora);
    var hora_envio = '';
    if (act.getHours() < 13) {
        hora_envio += act.getHours() + ':';
        hora_envio += (act.getMinutes() < 10 ? '0' : '') + act.getMinutes();
        hora_envio += ' a.m.';
    } else {
        hora_envio += (act.getHours() - 12) + ':';
        hora_envio += (act.getMinutes() < 10 ? '0' : '') + act.getMinutes();
        hora_envio += ' p.m.';
    }

    return hora_envio;
}

function ObtenerFecha(fecha) {
    if (fecha == null)
        return "----";

    const fecha_solicitada = new Date(fecha);
    const fecha_actual = new Date(Date.now());
    fecha_solicitada.setHours(0, 0, 0, 0);
    fecha_actual.setHours(0, 0, 0, 0);

    if (fecha_solicitada.getTime() === fecha_actual.getTime())
        return 'Hoy';
    else if (fecha_solicitada.getTime() === fecha_actual.setDate(fecha_actual.getDate() - 1))
        return 'Ayer';
    else {
        const meses = ["En.", "Febr.", "Mzo.", "Abr.", "May.", "Jun.", "Jul.", "Agto.", "Sept.", "Oct.", "Nov.", "Dic."];
        return fecha_solicitada.getDate() + " " + meses[fecha_solicitada.getMonth()] + " " + fecha_solicitada.getUTCFullYear();
    }
}

function Fecha_hora_ultima_Mensaje(fecha_mensaje) {
    const fecha_solicitada = new Date(fecha_mensaje);
    const fecha_actual = new Date(Date.now());
    fecha_solicitada.setHours(0, 0, 0, 0);
    fecha_actual.setHours(0, 0, 0, 0);

    if (fecha_solicitada.getTime() === fecha_actual.getTime())
        return new Date(fecha_mensaje).toLocaleString('en-US', {hour: 'numeric', minute: 'numeric', hour12: true}).toLowerCase();
    else if (fecha_solicitada.getTime() === fecha_actual.setDate(fecha_actual.getDate() - 1))
        return 'Ayer';
    else if (Math.trunc((fecha_actual - fecha_solicitada) / (1000 * 60 * 60 * 24)) < 7)
        return ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"][fecha_solicitada.getDay()];
    else if (fecha_actual.getFullYear() === fecha_solicitada.getFullYear())
        return fecha_solicitada.getDate() + "de " + [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto","Septiembre","Octubre", "Noviembre", "Diciembre"
        ][fecha_solicitada.getMonth()];
    else
        return fecha_solicitada.getDate() + "/" + fecha_solicitada.getMonth() + "/" + fecha_solicitada.getFullYear();
}

function ObtenerSegundosComoTiempo(seconds) {
    var hour = Math.floor(seconds / 3600);
    hour = (hour < 10)? '0' + hour : hour;
    var minute = Math.floor((seconds / 60) % 60);
    minute = (minute < 10)? '0' + minute : minute;
    var second = seconds % 60;
    second = (second < 10)? '0' + second : second;
    return (hour !== '00' ? hour + ':' : '') + minute + ':' + second.split(".")[0];
}