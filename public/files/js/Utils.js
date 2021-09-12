function Icon_Circle_Load(width = '1rem', height = '1rem', width_view = 52, height_view = 52, style = '') {
    return `<svg style='${style}' width='${width}' height='${height}' viewBox='0 0 ${width_view} ${height_view}' className='bi' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
        <path fill-rule="evenodd" d="M25,5A20.14,20.14,0,0,1,45,22.88a2.51,2.51,0,0,0,2.49,2.26h0A2.52,2.52,0,0,0,50,22.33a25.14,25.14,0,0,0-50,0,2.52,2.52,0,0,0,2.5,2.81h0A2.51,2.51,0,0,0,5,22.88,20.14,20.14,0,0,1,25,5Z">
            <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.5s" repeatCount="indefinite"/>
        </path>
    </svg>`;
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
const ObtenerUrlImagen = elemento_img => {
    const src = elemento_img.attr('src');
    return src.startsWith('data:image/') ? src : new URL( src, window.location.origin).pathname;
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
