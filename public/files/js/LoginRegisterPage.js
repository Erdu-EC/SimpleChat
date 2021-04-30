$(document).on('submit', "#user_form", null, function (event) {
    const user = $("#user_name").val();
    const pass = $("#user_pass").val();
    const action_alert = $("#action_alert");

    const color_info = "alert-info";
    const color_error = "alert-danger";

    $.ajax('/action/user/Login', {
        method: 'post',
        dataType: 'json',
        mimeType: 'application/json',
        data: {u: user, p: pass},
        beforeSend: () => action_alert.removeClass(color_error).addClass(color_info).text("Cargando..."),
        error: () => action_alert.removeClass(color_info).addClass(color_error).text("No fue posible iniciar sesion."),
        success: function (json) {
            if (json === true) {
                action_alert.removeClass(color_error).addClass(color_info).text('Sesion iniciada.');
                window.location = "/";
            } else
                action_alert.removeClass(color_info).addClass(color_error).text('Usuario o contraseña incorrecta.');
        }
    });

    return false;
});

$(document).on('submit', "#register_form", null, function (event) {
    const action_alert = $("#action_alert");

    const color_info = "alert-info";
    const color_error = "alert-danger";

    $.ajax('/action/user/Register', {
        method: 'post',
        dataType: 'json',
        mimeType: 'application/json',
        data: {
            u: $("#user_name").val(),
            p: $("#user_pass").val(),
            fn: $("#first_name").val(),
            ln: $("#last_name").val()
        },
        beforeSend: () => action_alert.removeClass(color_error).addClass(color_info).text("Cargando..."),
        error: () => action_alert.removeClass(color_info).addClass(color_error).text("No fue posible realizar el registro."),
        success: function (json) {
            if (json === true) {
                action_alert.removeClass(color_error).addClass(color_info).text('Registro completado.');
                window.location = "/Login";
            } else
                action_alert.removeClass(color_info).addClass(color_error).text('Datos incorrectos, registro no completado.');
        }
    });

    return false;
});

$(document).on('input', '#user_name', null, function (event) {
    if (this.validity.tooLong || this.validity.tooShort)
        this.setCustomValidity("El nombre de usuario debe tener un minimo de 4 caracteres y un maximo de 30.");
    else
        this.setCustomValidity('');
});

$(document).on('input', '#user_pass', null, function (event){
    if (this.validity.tooLong || this.validity.tooShort)
        this.setCustomValidity("La contraseña debe tener un minimo de 8 caracteres y un maximo de 60.");
    else
        this.setCustomValidity('');
});

$(document).on('input', '#user_pass_repeat', null, function (event) {
    if ($("#user_pass").val() !== this.value)
        this.setCustomValidity('La contraseña no coincide con la especificada anteriormente.');
    else
        this.setCustomValidity('');
});
