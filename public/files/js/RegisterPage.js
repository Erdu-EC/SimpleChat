/*Acciones de FrontEnd*/
$(document).ready(function () {
   $("input[type=date]").val("");
});
$(".input-group input#birth_date").focus(function (){
    $(this).css("color","#868580");
    var elemento =  $(this).parent().parent();
    elemento.addClass("activo");
    elemento.removeClass("error");
    $(this).removeClass("error");
});
$(".input-group input#birth_date").blur(function () {
    var elemento =  $(this).parent().parent();

    if($(this).val()==""){
        elemento.removeClass("activo");
        elemento.addClass("error");
        $(this).addClass("error");
        $(this).css("color","transparent");
    }else
    {
        $(this).addClass("valorado");
        $(".input-group input#birth_date").css("color","#171a1d");
    }

});

$(".item-form .input-group input").focus(function () {
var elemento =  $(this).parent().parent();
elemento.addClass("activo");
    elemento.removeClass("error");
    $(this).removeClass("error");
});

$(".item-form .input-group input").blur(function () {
    var elemento =  $(this).parent().parent();

    if($(this).val()==""){
        elemento.removeClass("activo");
        elemento.addClass("error");
       $(this).addClass("error");
    }else
    {
        $(this).addClass("valorado");
    }

});
$(".item-form .input-group #gender").click(function () {
    var elemento =  $(this).parent().parent();
    elemento.addClass("activo");
    elemento.removeClass("error");
    $(this).removeClass("error");
});
$(".item-form .input-group #gender").blur(function () {
    var elemento =  $(this).parent().parent();

    if($(this).val()==""){
        elemento.removeClass("activo");
        elemento.addClass("error");
        $(this).addClass("error");
    }

});
/*Fin de acciones de FrontEnd*/
$("button#registrar").click(function (e) {

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

/*
$(document).on('submit', "#user_form", null, function (e) {
    e.preventDefault();
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

*/