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
        error: function () {3
            if (!$("#error-solicitud").length) {
                 $("#user_form").before(' <div class="error-acceso" id="error-solicitud"> <span class="material-icons">error</span><span> Se ha producido un fallo con tu solicitud. Por favor, inténtalo de nuevo.</span></div>');
            };
            $("#user_pass").val("");
        },
        success: function (json) {
            if (json === true) {
                //Alert(ALERT_SUCCESS, 'Sesion iniciada.');
                window.location = "/";
            }
            else
            {
                if($(".card #error-solicitud").length){
                    $(".card #error-solicitud").remove();
                }
                if (!$("#error-inicioSesion").length) {

                    $(".card .card-header").after('<div class="error-acceso" id="error-inicioSesion"><span>Nombre de usuario o contraseña incorrectos.</span></div>');
                }
                $("#user_pass").val("");
            }


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