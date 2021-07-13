$(document).on('submit', "#user_form", null, function () {
    const mostrar_error = (texto_error) => {
        if ($('#error-login').length === 0)
            $("#user_form").before(' <div class="error-acceso" id="error-login"> <span class="material-icons">error</span><span> </span></div>');

        $('#error-login span:last-child').text(texto_error);
        $("#user_pass").val("");
    }

    $.ajax('/action/user/Login', {
        method: 'post',
        dataType: 'json',
        mimeType: 'application/json',
        data: {
            u: $("#user_name").val().trim(),
            p: $("#user_pass").val().trim()
        },
        error: () => mostrar_error('Se ha producido un fallo con tu solicitud. Por favor, inténtalo de nuevo.'),
        success: function (json) {
            if (json === true) {
                $('#error-login').remove();
                $("#user_form").before('<div id="iniciando-sesion"><div id="cargando"></div><span>Iniciando sesión</span></div>');

                window.location = "/";
            } else
                mostrar_error('Nombre de usuario o contraseña incorrectos.');
        }
    });

    return false;
});

$(document).on('input', '#user_pass', null, function () {
    if (this.validity.tooLong || this.validity.tooShort)
        this.setCustomValidity("La contraseña debe tener un mínimo de 8 caracteres y un maximo de 60.");
    else
        this.setCustomValidity('');
});


//FRONTEND
$("#btn-navbar-toggler").click(function () {
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo").toggleClass("inactivo");
});