/*-----------------------------------------------
Accione para estilos de la página
-----------------------------------------------*/
$(document).on("ready",function () {
    $("input[type=date]").val("");

    if ($("#first_name").val()!="") {
        var elemento =  $("#first_name").parent().parent();
        elemento.addClass("activo");
        elemento.removeClass("error");
        $(this).removeClass("error");
        console.log("El input tiene datos");
    }



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
$(".item-form .input-group select#gender").click(function () {
    var elemento =  $(this).parent().parent();
    elemento.addClass("activo");
    elemento.removeClass("error");
    $(this).removeClass("error");
});
$(".item-form .input-group select#gender").blur(function () {
    var elemento =  $(this).parent().parent();
if($("select#gender option:selected").text() == ""){

    elemento.removeClass("activo");
    elemento.addClass("error");
    $("select#gender").addClass("error");
}

});
$("#user_pass").focus(function () {
    $(".desplegable-recomendaciones-clave").addClass("visible");
});
$("#user_pass").blur(function () {
    $(".desplegable-recomendaciones-clave").removeClass("visible");
});
/*-----------------------------------------------
Fin accione para estilos de la página
-----------------------------------------------*/

/*-----------------------------------------------
Còdigo de acciones para enviar datos al servidor
-----------------------------------------------*/

$(document).on('submit', "#register_form", null, function (e) {

    $.ajax('/action/user/Register', {
        method: 'post',
        dataType: 'json',
        mimeType: 'application/json',
        data: {
            u: $("#user_name").val(),
            p: $("#user_pass").val(),
            fn: $("#first_name").val(),
            ln: $("#last_name").val(),
            gen: $("#gender").val(),
            birth: $("#birth_date").val(),
            phone: $("#user_phone").val()
        },
        beforeSend: () => Alert(ALERT_NORMAL, "Cargando..."),
        error: () => Alert(ALERT_ERROR, "No fue posible realizar el registro."),
        success: function (json) {
            if (json[0] === true) {
                swal({
                    title: "Registro exitoso",
                    text: "Usted ha sido registrado correctamente",
                    icon: "success",
                    confirmButtonText: "Ok"
                }).then(
                    function () {
                        window.location = "/Login";
                    }
                );

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
        $("#contenedor-mensajes").html('<div class="mensaje-error no-coincide"><span class="material-icons">error</span> Las contraseñas no coinciden </div>');
    else
        $("#contenedor-mensajes .no-coincide").remove();
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
/*----------------------------------------------------
Fin de còdigo de acciones para enviar datos al servidor
------------------------------------------------------*/
//FRONTEND
$("#btn-navbar-toggler").click(function () {
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo").toggleClass("inactivo");
});