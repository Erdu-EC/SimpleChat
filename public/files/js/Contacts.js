$(document).ready(refresh_contact_list);
//$(document).ready(() => $('#chat-container').load('/Chats/'));

$(document).on('input', '#user-search-box', function (){
    const alert_contact = $('#alert-search-status');
    const result_list = $('#user-search-result');

    if ($(this).val().length > 3){
        $.ajax('/action/users/search', {
            method: 'post',
            dataType: 'json',
            mimeType: 'application/json',
            data: { text: $(this).val() },
            beforeSend: () => alert_contact.text("Buscando..."),
            error: () => alert_contact.text("No fue posible realizar la busqueda."),
            success: function (json) {
                alert_contact.html('');
                result_list.html('');

                if (json === null)
                    alert_contact.text('No fue posible realizar la busqueda.');
                else if (json.length === 0)
                    alert_contact.text('No hay coincidencias.');
                else{
                    alert_contact.text(`Se ha encontrado ${json.length} coincidencias.`);

                    for (let i = 0; i < json.length; i++){
                        const row = json[i];
                        result_list.append(GetSearchItem(row[2], row[3], row[1], row[4]));
                    }
                }
            }
        });
    }else{
        alert_contact.html('');
        result_list.html('');
    }
})

$(document).on('click', '.contact-item', function (){
    $('#chat-container').load(`/Chats/${$(this).attr('data-usuario')}`)
})

function refresh_contact_list(){
    const alert_contact = $('#alert-contacts-list');

    $.ajax('/action/users/contacts', {
        method: 'get',
        dataType: 'json',
        mimeType: 'application/json',
        error: () => alert_contact.text('No fue posible cargar la lista de contactos.'),
        success: function (json) {
            if (json === null)
                alert_contact.text('No fue posible cargar la lista de contactos.');
            else if (json.length === 0)
                alert_contact.html('Tu lista de contactos esta vacia.<br/><br/>¡Busca nuevos contactos y agregalos!');
            else{
                alert_contact.text('¡Busca nuevos contactos y agregalos!')

                const list = $('#contacts-list').html('');

                for (let i = 0; i < json.length; i++){
                    const item = $('<li>', {
                        class: 'list-group-item ps-0 pe-0',
                        html: GetContactItem(json[i][0], json[i][1], json[i][2], json[i][3]),
                    }).appendTo(list);
                }
            }
        }
    });
}

const GetSearchItem = (first_name, last_name, last_conn, isContact) => `<div class="card mb-2 contact-item shadow" style="cursor: pointer;">
                            <div class="row g-0">
                                <div class="col-md-3 p-1">
                                    <img src="/files/profile/0_erdu.png" class="img-fluid" alt="profile">
                                </div>
                                <div class="col-md-9 align-self-center">
                                    <div class="card-body p-2">
                                        <h6 class="card-title">${first_name} ${last_name}</h6>
                                        <p class="card-text flex-row" style="font-size: .8rem;">
                                            <small class="text-muted">
                                                ${(isContact) ?
                                                    '<i class="material-icons" style="vertical-align: middle">person</i><span>Mi contacto</span>'
                                                    : ''
                                                }
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>`

const GetContactItem = (user_name, first_name, last_name, last_conn) => `<div class="card mb-2 contact-item" data-usuario="${user_name}">
                            <div class="row g-0">
                            <div class="col-md-3 p-1">
                                <img src="/files/profile/0_erdu.png" class="img-fluid" alt="profile">
                            </div>
                            <div class="col-md-9 align-self-center">
                                <div class="card-body p-2">
                                    <h6 class="card-title">${first_name} ${last_name}</h6>
                                    <p class="card-text" style="font-size: .8rem;"><small class="text-muted">${(last_conn !== undefined) ? GetTimeAgo(last_conn) : ''}</small></p>
                                </div>
                            </div>
                        </div>`;

function GetTimeAgo(last_conn){
    const date = new Date(last_conn);
    return 'Activo el ' + date.toLocaleDateString() + " a las " + date.toLocaleTimeString();
}