/*-----------------------------------------------
Acciones para estilos de la página
-----------------------------------------------*/

$(document).ready(() => {
    $("input[type=date]").val("");

    const firstName = $("#first_name");
    if (firstName.val() !== "") {
        const elemento = firstName.parent().parent();
        elemento.addClass("activo").removeClass("error");
        firstName.removeClass("error");
    }
});

const handleInputFocus = function () {
    const elemento = $(this).parent().parent();
    elemento.addClass("activo").removeClass("error");
    $(this).removeClass("error");
};

const handleInputBlur = function () {
    const elemento = $(this).parent().parent();

    if ($(this).val() === "") {
        elemento.removeClass("activo").addClass("error");
        $(this).addClass("error").css("color", "transparent");
    } else {
        $(this).addClass("valorado");
        $(this).css("color", "#171a1d");
    }
};

const handleGenderBlur = function () {
    const elemento = $(this).parent().parent();
    if ($("#gender option:selected").text() === "") {
        elemento.removeClass("activo").addClass("error");
        $("#gender").addClass("error");
    }
};

const handlePasswordFocus = function () {
    $(".desplegable-recomendaciones-clave").addClass("visible");
};

const handlePasswordBlur = function () {
    $(".desplegable-recomendaciones-clave").removeClass("visible");
};

const handlePhoneKeyDown = function (e) {
    const key = e.key.charCodeAt();
    if (
        e.key === "Backspace" ||
        e.key === "ArrowRight" ||
        e.key === "ArrowLeft" ||
        e.key === "Tab" ||
        e.key === "Enter" ||
        (key >= 48 && key <= 57)
    ) {
        return key;
    } else {
        e.preventDefault();
    }
};

$("#birth_date").on("change", function () {
    ValidarFechaNacimiento();
});

$("#user_email").on("input", function () {
    ValidarEmail();
});

$("#user_name").on("input", function () {
    ValidarUsuario($(this), "apellido");
});

$("#user_pass_repeat").on("input", function () {
    ValidarContrasenas();
});

$(".item-form .input-group input, #gender").on("blur", handleInputBlur);

$(".item-form .input-group input, #gender").on("focus", handleInputFocus);

$(".item-form .input-group select#gender").on("blur", handleGenderBlur);

$("#user_pass").on("focus", handlePasswordFocus);

$("#user_pass").on("blur", handlePasswordBlur);

$("#user_phone").on("keydown", handlePhoneKeyDown);

$("#first_name").on("input", () => {
    ValidarNombreApellido($("#first_name"), "nombre");
});

$("#last_name").on("input", () => {
    ValidarNombreApellido($("#last_name"), "apellido");
});

$("#gender").on("change", () => {
    ValidarGenero();
});
/*-----------------------------------------------
Fin accione para estilos de la página
-----------------------------------------------*/

/*-----------------------------------------------
Còdigo de acciones para enviar datos al servidor
-----------------------------------------------*/

$(document).on('submit', "#register_form", function (e) {
e.preventDefault();
var continuar = true;
    $("#contenedor-mensajes").empty();
    if(!ValidarNombreApellido($("#first_name"),"nombre")){
       continuar= false;
    }
    if(!ValidarNombreApellido($("#last_name"), "apellido")){
        continuar= false;
    }

    if (!ValidarGenero()){
        continuar= false;
    }
    if(!ValidarFechaNacimiento()){
        continuar= false;
    }
    if(!ValidarTelefono()){
        continuar= false;
    }
    if(!ValidarUsuario()){
        continuar= false;
    }
    if(!ValidarContrasenas()){
        continuar= false;
    }
    if(!ValidarEmail()){
        continuar= false;
    }

    if (continuar){
        $.ajax('/action/user/Register', {
            method: 'post',
            dataType: 'json',
            mimeType: 'application/json',
            data: {


                fn: $("#first_name").val(),
                ln: $("#last_name").val(),
                gen: $("#gender").val(),
                birth: $("#birth_date").val(),
                phone: $("#user_phone").val(),
                email: $("#user_email").val(),
                u: $("#user_name").val(),
                p: $("#user_pass").val(),
                p_rep: $("#user_pass_repeat").val()
            },
            beforeSend: () => {
                $("#contenedor-mensajes").append('<div id="enviando-datos"><div class="cargando"></div>Enviando datos</div>')
            },
            error: () => {
                $("#contenedor-mensajes").empty();
                swal({
                   text: "No se ha podido completar el registro en SimpleChat. Revise su conexion a Internet.",
                    icon: "error",
                    button: "ok",
                });
            },
            success: function (json) {
                $("#contenedor-mensajes").empty()
                if (json[0] === true) {
                    swal({
                        title: "Registro exitoso",
                        text: "Usted ha sido registrado correctamente en SimpleChat.",
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
                            swal({
                                text: "Ya existe una sesión iniciada con este usuario.",
                                icon: "info",
                                confirmButtonText: "Ok"
                            }).then(
                                function () {
                                    window.location = "/";
                                }
                            );
                           // $("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>Ya existe una sesión iniciada.</div>');
                            break;
                        case 1:
                            IndicarError("Uno de los campos está vacío. Por favor, verifique todos los campos.");
                            break;
                        case 2:
                            IndicarError("Ingrese un nombre válido. 2 caracteres mín.");
                            break;
                        case 3:
                            IndicarError("Ingrese un apellido válido. 2 caracteres mín.");
                            // $("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>No fue posible asegurar la contraseña.</div>');
                            break;
                        case 4:
                            IndicarError("Seleccione una opción de género válido.");
                            //$("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>Utilice otro nombre de usuario.</div>');
                            MostrarMensajeError($("#user_name").parent(), "El nombre de usuario ya existe.")
                            break;
                        case 5:
                            IndicarError("Ingrese una fecha de nacimiento válida.");
                            break;
                        case 6:
                            IndicarError("Ingrese un número de teléfono válido.");
                            break;
                        case 7:
                            IndicarError("Ingrese una dirección de correo válida.");
                            break;
                        case 8:
                            IndicarError("Ingrese un nombre de usuario válido. 4 caracteres mín.");
                            break;
                        case 9:
                            IndicarError("Verifique que ambas contraseñas coinciden. 8 caracteres mín. y 60 caracteres máx.")
                            break;
                        case 10:
                            IndicarError("El nombre de usuario ya se encuentra en uso. Por favor introduzca otro nombre de usuario e intente nuevamente.");
                            break;
                        default:
                            $("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>Error desconocido, registro no completado.</div>');

                            break;
                    }

                }
            }
        });
    }else{
        $("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>Por favor verifique todos los campos.</div>');

    }
});


/*-----------------------------------------------
Funciones de validacion de campos
-----------------------------------------------*/

$(document).on('input', '#user_pass', null, function () {

    var info_nivel = $("#indicador-nivel-seguridad");
    var nivel=0;
    info_nivel.removeClass();
    if ($(this).val().length > 7){
        nivel += 1;
        if (Coincidencia($(this).val(),"0123456789" )){
            nivel += 1;
        }
        if (Coincidencia($(this).val(),"ABCDEFGHIJKLMNÑOPQRSTUVWXYZ" )){
            nivel += 1;
        }
        if (CoincidenciaCaracteresEspeciales($(this).val(),"ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyz")){
            nivel += 1;
        }


    }
    switch (nivel){
        case 0:
            info_nivel.addClass("debil");
            $("#indicador-nivel-seguridad span").text("Débil");
            break;
        case 1:
            info_nivel.addClass("regular");
            $("#indicador-nivel-seguridad span").text("Regular");
            break;
        case 2:
            info_nivel.addClass("media");
            $("#indicador-nivel-seguridad span").text("Media");
            break;
        case 3:
        case 4:
            info_nivel.addClass("fuerte");
            $("#indicador-nivel-seguridad span").text("Fuerte");
            break;
    }
    ValidarContrasenas();
});
function Coincidencia(cadena, cadena_referencia){
    for(i=0; i<cadena.length; i++){
        if (cadena_referencia.indexOf(cadena.charAt(i),0)!=-1){
            return true;
        }
    }
    return false;
}
function CoincidenciaCaracteresEspeciales(cadena, cadena_referencia){
    for(i=0; i<cadena.length; i++){
        if (cadena_referencia.indexOf(cadena.charAt(i),0)==-1){
            return true;
        }
    }
    return false;
}

function ValidarNombreApellido(elemento, campo_nombre) {
    elemento.parent().siblings(".indicador-error").remove();
    if(elemento.val().length < 2){
        MostrarMensajeError(elemento.parent(), "Ingrese un "+campo_nombre+" válido. 2 caract. mín.");
        return false;
    }
    return true;
}

function ValidarGenero(){
    var elemento = $("#gender");
    elemento.parent().siblings(".indicador-error").remove();
if(elemento.val()== null){
    MostrarMensajeError(elemento.parent(), "Elige una opción.");
    return false;
}
return true;
}
function ValidarFechaNacimiento() {
    var elemento = $("#birth_date");
    elemento.parent().siblings(".indicador-error").remove();

    var fecha_seleccionada = new Date(elemento.val()+ " 00:00:00");
    var fecha_actual = new Date();

var fecha_minima = new Date("1900-01-01");

    if(elemento.val()== null ||elemento.val()=="" ){
        MostrarMensajeError(elemento.parent(), "Ingrese una fecha válida.");
        return false;
    }
     else if(fecha_seleccionada < fecha_minima){
           MostrarMensajeError(elemento.parent(), "Ingrese una fecha válida.");
           return false;
       }
     else if(fecha_seleccionada > fecha_actual)
     {
             MostrarMensajeError(elemento.parent(), "Ingrese una fecha válida.");

             return false;
         }
    return true;
}
function ValidarTelefono() {
    var elemento = $("#user_phone");
    elemento.parent().siblings(".indicador-error").remove();
    if((elemento.val().length > 0 && elemento.val().length < 8) || elemento.val().length > 15){
        MostrarMensajeError(elemento.parent(), "Ingrese un número de teléfono válido.");
        return false;
    }
    return true;
}
function ValidarEmail(){
    var elemento=  $("#user_email");
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    elemento.parent().siblings(".indicador-error").remove();

    if(elemento.val().length == 0 ){
        MostrarMensajeError(elemento.parent(),'El formato de correo no es válido');
        return  false;
    }
    else if(!regex.test(elemento.val()) ){
        MostrarMensajeError(elemento.parent(),'El formato de correo no es válido');
        return  false;
    }
    return true;
}

function ValidarUsuario() {
    var elemento = $("#user_name");
    elemento.parent().siblings(".indicador-error").remove();
    if(elemento.val().length < 4 ) {
        MostrarMensajeError(elemento.parent(), "El nombre de usuario debe contener al menos 4 caracteres.");
        return false;
    }
     else if(elemento.val().length > 30){
        MostrarMensajeError(elemento.parent(), "El nombre de usuario debe tener 30 caracteres máx.");
        return false;
    }
    return  true;
}
function ValidarContrasenas() {
    var clave = $("#user_pass")
    var clave_rep = $("#user_pass_repeat");
    clave_rep.parent().siblings(".indicador-error").remove();
    $("#contenedor-mensajes .no-coincide").remove();
    if ( clave.val() != clave_rep.val()){
            $("#contenedor-mensajes").prepend('<div class="mensaje-error no-coincide"><span class="material-icons">error</span> Las contraseñas no coinciden </div>');
        return false;
    }
    else if(clave.val().length < 8 || clave_rep.val().length < 8){
        MostrarMensajeError(clave_rep .parent(), "Su contraseña debe tener al menos 8 caracteres.");
    return false;
    }
    else if(clave.val().length > 60 || clave_rep.val().length > 60){
        MostrarMensajeError(clave_rep .parent(), "Su contraseña debe tener un máximo de 60 caracteres.");
        return false;
    }
    return  true;
}
//Alertas de error
function MostrarMensajeError(elemento, texto){
if(elemento.siblings(".indicador-error").length == 0){
    elemento.after('<div class="indicador-error">'+ texto +'</div>');
}
}

function IndicarError($mensaje) {
    swal({
        tittle:"No se ha completado el registro",
        text: $mensaje,
        icon: "error",
        button: "Ok",
        dangerMode: true
    });
}

/*----------------------------------------------------
Fin de còdigo de acciones para enviar datos al servidor
------------------------------------------------------*/
//FRONTEND
$("#btn-navbar-toggler").click(function () {
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo").toggleClass("inactivo");
    if( $("nav.menu-navegacion ul.nav-lista").hasClass('activo')){
        $("#btn-navbar-toggler").html('<span class="material-icons">close</span>');
    }
    else{
        $("#btn-navbar-toggler").html('<span class="material-icons">menu</span>');
    }
});
