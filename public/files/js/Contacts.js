$(document).ready(refresh_contact_list);

$(document).on('input', '#user-search-box', function (){
    if ($(this).val().length > 3){
        console.log("Buscando...")
    }
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
                        class: 'list-group-item contact-item ps-0 pe-0',
                        html: GetContactItem(json[i].first_name, json[i].last_name, json[i].last_connection),
                    }).attr("data-id", json[i].id).appendTo(list);
                }
            }
        }
    });
}

const GetContactItem = (first_name, last_name, last_conn) => `<div class="card mb-2 contact-item"">
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