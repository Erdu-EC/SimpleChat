$(document).on('submit', "#user_form", null, function () {
    $.ajax('/action/user/Login', {
        method: 'post',
        dataType: 'json',
        mimeType: 'application/json',
        data: {
            u: $("#user_name").val(),
            p: $("#user_pass").val()
        },
        beforeSend: () => Alert(ALERT_NORMAL, "Cargando..."),
        error: () => Alert(ALERT_ERROR, "No fue posible iniciar sesion."),
        success: function (json) {
            if (json === true) {
                Alert(ALERT_SUCCESS, 'Sesion iniciada.');
                window.location = "/";
            } else
                Alert(ALERT_ERROR, 'Usuario o contraseña incorrecta.');
        }
    });

    return false;
});

$(document).on('submit', "#register_form", null, function () {
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
        beforeSend: () => Alert(ALERT_NORMAL, "Cargando..."),
        error: () => Alert(ALERT_ERROR, "No fue posible realizar el registro."),
        success: function (json) {
            if (json[0] === true) {
                Alert(ALERT_SUCCESS, 'Registro completado.');
                window.location = "/Login";
            } else {
                switch (json[1]) {
                    case 0:
                        Alert(ALERT_ERROR, "Ya existe una sesión iniciada.");
                        break;
                    case 3:
                        Alert(ALERT_ERROR, "No fue posible asegurar la contraseña.");
                        break;
                    case 4:
                        Alert(ALERT_ERROR, "El nombre de usuario ya existe.");
                        break;
                    default:
                        Alert(ALERT_ERROR, 'Error desconocido, registro no completado.');
                        break;
                }

            }
        }
    });

    return false;
});

$(document).on('input', '#user_name', null, function () {
    if (this.validity.tooLong || this.validity.tooShort)
        this.setCustomValidity("El nombre de usuario debe tener un minimo de 4 caracteres y un maximo de 30.");
    else
        this.setCustomValidity('');
});

$(document).on('input', '#user_pass', null, function () {
    if (this.validity.tooLong || this.validity.tooShort)
        this.setCustomValidity("La contraseña debe tener un minimo de 8 caracteres y un maximo de 60.");
    else
        this.setCustomValidity('');
});

$(document).on('input', '#user_pass_repeat', null, function () {
    if ($("#user_pass").val() !== this.value)
        this.setCustomValidity('La contraseña no coincide con la especificada anteriormente.');
    else
        this.setCustomValidity('');
});

const ALERT_NORMAL = 1;
const ALERT_ERROR = 2;
const ALERT_SUCCESS = 3;

function Alert(code, msg) {
    const action_alert = $("#action_alert");

    const color_info = "alert-info";
    const color_error = "alert-danger";

    switch (code) {
        case ALERT_SUCCESS:
        case ALERT_NORMAL:
            action_alert.removeClass(color_error).addClass(color_info).text(msg)
            break;
        case ALERT_ERROR:
            action_alert.removeClass(color_info).addClass(color_error).text(msg)
            break;
    }
}