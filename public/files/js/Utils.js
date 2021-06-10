function Icon_Circle_Load(width = '1rem', height = '1rem', width_view = 52, height_view = 52, style = '') {
    return `<svg style='${style}' width='${width}' height='${height}' viewBox='0 0 ${width_view} ${height_view}' className='bi' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
        <path fill-rule="evenodd" d="M25,5A20.14,20.14,0,0,1,45,22.88a2.51,2.51,0,0,0,2.49,2.26h0A2.52,2.52,0,0,0,50,22.33a25.14,25.14,0,0,0-50,0,2.52,2.52,0,0,0,2.5,2.81h0A2.51,2.51,0,0,0,5,22.88,20.14,20.14,0,0,1,25,5Z">
            <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.5s" repeatCount="indefinite"/>
        </path>
    </svg>`;
}

function GetHtmlCircleLoadContainer(width, height, clase = '') {
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



