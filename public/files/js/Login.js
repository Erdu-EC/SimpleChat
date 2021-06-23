$(document).on('submit', "#user_form", null, function () {
    $.ajax('/action/user/Login', {
        method: 'post',
        dataType: 'json',
        mimeType: 'application/json',
        data: {
            u: $("#user_name").val(),
            p: $("#user_pass").val()
        },
        //beforeSend: () => Alert(ALERT_NORMAL, "Cargando..."),
        //error: () => Alert(ALERT_ERROR, "No fue posible iniciar sesion."),
        success: function (json) {
            if (json === true) {
                //Alert(ALERT_SUCCESS, 'Sesion iniciada.');
                window.location = "/";
            }/* else
                Alert(ALERT_ERROR, 'Usuario o contraseña incorrecta.');*/
        }
    });

    return false;
});


$(document).on('input', '#user_pass', null, function () {
    if (this.validity.tooLong || this.validity.tooShort)
        this.setCustomValidity("La contraseña debe tener un minimo de 8 caracteres y un maximo de 60.");
    else
        this.setCustomValidity('');
});


$("#btn-navbar-toggler").click(function (){
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo");
    $("nav.menu-navegacion ul.nav-lista").toggleClass("inactivo");
});