$(document).ready(function (){
    const alert_contact = $('#alert-contacts-list');

    $.ajax('/action/users/all', {
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
                        class: 'list-group-item contact-item',
                        html: json[i].user_name + '<button class="btn btn-outline-primary material-icons align-self-end">add_circle_outline</button>',
                    }).appendTo(list);
                }
            }
        }
    });
});

$(document).on('click', '.contact-item', function (){
    console.log("Contacto agregado...");
})