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
$("#user_phone").keydown( function (e) {
    var key =  e.key.charCodeAt(0);
    if ((key == 8 ||
            key == 9 ||
            key == 66 ||
            key == 13 ||
            key == 65 ) ||
        (key >= 48 && key <= 57))
    {
        return key;
    }else{
        e.preventDefault();
    };
});
$("#first_name").on("input", function () {
    ValidarNombreApellido($(this), "nombre");
});
$("#last_name").on("input", function () {
    ValidarNombreApellido($(this), "apellido");
});
$("#gender").change(function () {
    ValidarGenero();
});
$("#birth_date").on("change", function () {
    ValidarFechaNacimiento();
});
$("#user_phone").on("input", function () {
    ValidarTelefono();
});
$("#user_name").on("input", function () {
    ValidarUsuario($(this), "apellido");
});
$(document).on('input', '#user_pass_repeat', null, function () {
    ValidarContrasenas();
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

    if (continuar){
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
                            $("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>Ya existe una sesión iniciada.</div>');
                            break;
                        case 3:
                            $("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>No fue posible asegurar la contraseña.</div>');
                            break;
                        case 4:
                            $("#contenedor-mensajes").append('<div class="mensaje-error verificar"><span class="material-icons">error</span>Utilice otro nombre de usuario.</div>');
                            MostrarMensajeError($("#user_name").parent(), "El nombre de usuario ya existe.")
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



/*
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
*/
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
    if ( clave.val()!= clave_rep.val()){
            $("#contenedor-mensajes").prepend('<div class="mensaje-error no-coincide"><span class="material-icons">error</span> Las contraseñas no coinciden </div>');

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

function MostrarMensajeError(elemento, texto){
if(elemento.siblings(".indicador-error").length == 0){
    elemento.after('<div class="indicador-error">'+ texto +'</div>');
}
}

/*----------------------------------------------------
Fin de còdigo de acciones para enviar datos al servidor
------------------------------------------------------*/
//FRONTEND
$("#btn-navbar-toggler").click(function () {
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo").toggleClass("inactivo");
});